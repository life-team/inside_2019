#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct vertex {
	struct vertex **nei;
	unsigned int size_nei;
	char *name;
	char *message;

	int level;
};

struct queue {
	struct vertex *value;
	struct queue *next;
};

struct vertex **graph = NULL;
unsigned int size = 0;

struct queue *head, *tail;

void push(struct vertex *g) {
	struct queue *new = (struct queue*) malloc(sizeof(struct queue));

	new->value = g;
	new->next = NULL;

	if (head != NULL)
		head->next = new;

	if (tail == NULL)
		tail = new;

	head = new;
}

void pop(struct vertex **val) {
	struct queue *ptr = tail;

	if (head == NULL) {
		*val = NULL;
		return;
	}
	*val = tail->value;
	if (tail == head)
		head = NULL;
	tail = tail->next;
	free(ptr);
}

void reset() {
	struct queue *ptr = tail;

	while (tail != NULL) {
		tail = tail->next;
		free(ptr);
		ptr = tail;
	}
	head = NULL;
}

struct vertex * create_vertex(char *name, char *message) {
	struct vertex *new = (struct vertex *)malloc(sizeof(struct vertex));

	new->name = (char *) malloc(strlen(name) + 1);
	new->message = (char *) malloc(strlen(message) + 1);
	new->level = 0;

	strcpy(new->name, name);
	strcpy(new->message, message);

	new->nei = NULL;
	new->size_nei = 0;

	return new;
}

void add_vertex(char *name, char *message) {
	struct vertex **new_graph = (struct vertex **)
		malloc(sizeof(struct vertex *) * (size + 1));
	unsigned int i;

	for (i = 0; i < size; ++i)
		new_graph[i] = graph[i];
	new_graph[i] = create_vertex(name, message);

	if (graph != NULL)
		free(graph);
	graph = new_graph;
	++size;
}

void remove_vertex(struct vertex *v) {
	if (v->size_nei)
		free(v->nei);
	free(v->name);
	free(v->message);
}

void add_neighbor(struct vertex *dst, struct vertex *src) {

	struct vertex **new_nei = (struct vertex **)
		malloc((dst->size_nei + 1) * sizeof(struct vertex *));
	unsigned int i;

	for (i = 0; i < dst->size_nei; ++i)
		new_nei[i] = dst->nei[i];
	new_nei[i] = src;
	if (dst->nei != NULL)
		free(dst->nei);
	dst->nei = new_nei;
	++dst->size_nei;
}

int add_edge(struct vertex *g1, struct vertex *g2) {

	if (g1 == NULL || g2 == NULL)
		return -1;
	add_neighbor(g1, g2);
	add_neighbor(g2, g1);
	return 0;
}

struct vertex *find_vertex(char *name) {
	unsigned int i;

	for (i = 0; i < size; ++i)
		if (strcmp(name, graph[i]->name) == 0)
			return graph[i];
	return NULL;
}

void init() {
	head = NULL;
	tail = NULL;
	graph = NULL;
	size = 0;

	//random create graph
}

void deinit() {
	unsigned int i;

	for (i = 0; i < size; ++i) {
		free(graph[i]->name);
		free(graph[i]->message);
		free(graph[i]->nei);
		free(graph[i]);
	}
	free(graph);
}

void clear_graph() {
	unsigned int i;

	for (i = 0; i < size; ++i) {
		graph[i]->level = 0;
	}
}

void print_graph() {
	unsigned int i, j;

	for (i = 0; i < size; ++i) {
		printf("%u) name: %s nei: ", i, graph[i]->name);
		for (j = 0; j < graph[i]->size_nei; ++j)
			printf("%s ", graph[i]->nei[j]->name);
		if (graph[i]->level < 0)
			printf("message: %s ", graph[i]->message);
		printf("lvl: %d", graph[i]->level);
		printf("\n");
	}
}

void print_menu() {
	printf("*** main menu ***\n");
	printf("1 - print graph\n");
	printf("2 - add vertex\n");
	printf("3 - add edge\n");
	printf("\n0 - exit\n");
}

void BFS() {
	struct vertex *ptr = NULL;
	struct vertex *prev = NULL;
	int level = 1;
	int flag = 0;
	unsigned int i;

	clear_graph();
	push(*graph);
	while (tail != NULL) {
		pop(&ptr);
		for (i = 0; i < ptr->size_nei; ++i) {
			if (ptr->nei[i]->level == 0) {
				push(ptr->nei[i]);
			} else {
				++flag;
			}
		}
		if (flag > 1) {
			ptr->level = -1;
			reset();
			return;
		} else {
			ptr->level = level++;
			flag = 0;
		}
	}
}

int main() {
	int input;
	char name[5];
	char *message = "user vertex";
	unsigned int number = 0;
	struct vertex *vert;

	init();

	print_menu();
	while(1) {
		if (input == '\n')
			print_menu();
		input = getchar();
		switch(input) {
		case '0':
			deinit();
			return 0;
		case '1':
			print_graph();
			break;
		case '2':
			snprintf(name, 5, "%05d", number++);
			add_vertex(name, message);
			BFS();
			break;
		case '3':
			printf("enter name first vertex: ");
			scanf("%4s", name);
			vert = find_vertex(name);
			if (vert == NULL) {
				printf("vertex not found!\n");
				continue;
			}
			printf("enter name second vertex: ");
			scanf("%4s", name);
			if (add_edge(vert, find_vertex(name)) != 0) {
				printf("add edge - fail\n");
				continue;
			}
			BFS();
			break;
		default:
			break;
		}
	}

	return 0;
}
