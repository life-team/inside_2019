#define _GNU_SOURCE
#include <sys/types.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <pthread.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <error.h>
#include <inttypes.h>
#include <unistd.h>
#include <time.h>

#define FLAG "CTF{We@k_t0_Find_2_m0re_solutions?}"
#define NAME "doctor"

#define IF_ERROR(rc, func, rt) do { \
				if (rc < 0) { \
					perror(func); \
					return rt; \
				} \
				} while(0)

#define BUF_SIZE	256
#define PORT		778

#define KEY "Super mega key123"
#define KEY_LEN 16

#define OK "ok"
#define OK_LEN 3

char *key = KEY;
char *message = NULL;

int sv_sock = -1;

pthread_mutex_t mutex;

int super_decrypt(char *message) {
	uint32_t i;

	for (i = 0; message[i]; ++i) {
		message[i] = message[i] ^ key[i % 16];
	}
	message[i] = message[i] ^ key[i % 16];
	return 0;
}

void get_coord(char* buf, int sock)
{
	printf("get\n");
	snprintf(buf, BUF_SIZE, "%03u,%u° %03u,%u°",
			rand() % 180, rand(), rand() % 180, rand());
	send(sock, buf, strlen(buf)+1, 0);
}
void get_time(char *buf, int sock)
{
	time_t t = time(NULL);
	struct tm *lct = localtime(&t);

	printf("time\n");
	strncpy(buf, asctime(lct), BUF_SIZE);
	send(sock, buf, strlen(buf)+1, 0);
}

void rcv(char *buf, int sock)
{
	printf("rcv message %s\n", buf + 5);
	pthread_mutex_lock(&mutex);
	if (strcmp(buf + 5, "") != 0) {
		if (message != NULL)
			free(message);
		message = (char *)malloc(strlen(buf+5)+1);
		strcpy(message, buf + 5);
	}
	send(sock, OK, strlen(OK)+1, 0);
	pthread_mutex_unlock(&mutex);
}

void snd(int sock)
{
	printf("snd message\n");
	pthread_mutex_lock(&mutex);
	if (message == NULL)
		send(sock, OK, strlen(OK)+1, 0);
	else
		send(sock, message, strlen(message)+1, 0);
	pthread_mutex_unlock(&mutex);
}

void * thread_func(void *args)
{
	int sock = *(int *)args;
	char buf[BUF_SIZE];
	char *ptr;
	ssize_t size;

	while (1) {
		size = recv(sock, buf, BUF_SIZE, 0);
		if (size < 0) {
			perror("recv");
			continue;
		} else if (size == 0) {
			break;
		}

		if (strncmp(buf, "/get", 5) == 0) {
			get_coord(buf, sock);
		} else if (strncmp(buf, "/time", 5) == 0) {
			get_time(buf, sock);
		} else if (strncmp(buf, "/rcv", 5) == 0) {
			rcv(buf, sock);
		} else if (strncmp(buf, "/snd", 5) == 0) {
			snd(sock);
		} else if (strncmp(buf, "/login/", 7) == 0) {
			printf("login\n");
			ptr = &buf[7];
			if (strncmp(ptr, "admin", 5) == 0) {
				send(sock, "perm", 5, 0);
				break;
			} else if (strncmp(ptr, NAME, strlen(NAME)) == 0) {
				send(sock, "ok/0", 5, 0);
			} else {
				send(sock, "fail", 5, 0);
				break;
			}
		} else if (strncmp(buf, "/get_flag", 9) == 0) {
			printf("%d get_flag fail\n", sock);
			send(sock, "unknown command", 16, 0);
		} else {
			super_decrypt(buf);
			if (strncmp(buf, "/get_flag", 9) == 0) {
				printf("%d get_flag\n", sock);
				send(sock, FLAG, strlen(FLAG)+1, 0);
			} else if (strncmp(buf, "/get", 5) == 0) {
				get_coord(buf, sock);
			} else if (strncmp(buf, "/time", 5) == 0) {
				get_time(buf, sock);
			} else if (strncmp(buf, "/rcv", 5) == 0) {
				rcv(buf, sock);
			} else if (strncmp(buf, "/snd", 5) == 0) {
				snd(sock);
				send(sock, "unknown command", 16, 0);
			}
		}

		memset(buf, 0, BUF_SIZE);
	}
	printf("client %d lost\n", sock);
	if (close(sock) != 0)
		perror("close");
	pthread_exit(0);
}

static void dest() __attribute((destructor));

void dest() {
	pthread_mutex_destroy(&mutex);
	if (sv_sock >= 0)
		close(sv_sock);
}

int main() {
	int sock = -1, rc;
	struct sockaddr_in addr = { 0 };

	pthread_mutex_init(&mutex, NULL);

	addr.sin_family = AF_INET;
	addr.sin_port = htons(PORT);
	addr.sin_addr.s_addr = htonl(INADDR_ANY);

	sock = socket(AF_INET, SOCK_STREAM, 0);
	rc = bind(sock, (struct sockaddr *)&addr, sizeof(addr));
	IF_ERROR(rc, "bind", -1);
	sv_sock = sock;

	rc = listen(sock, 100);
	IF_ERROR(rc, "listen", -2);

	while (1) {
		int cl_sock;
		pthread_t thr;
		struct sockaddr_in cl_addr;
		socklen_t cl_addr_len;

		cl_sock = accept(sock, (struct sockaddr *)&cl_addr, &cl_addr_len);
		IF_ERROR(cl_sock, "accept", -3);

		printf("connect %d from %hhd.%hhd.%hhd.%hhd %u\n", cl_sock,
				(uint8_t)(cl_addr.sin_addr.s_addr & 0xFF),
				(uint8_t)((cl_addr.sin_addr.s_addr & 0xFF) << 8),
				(uint8_t)((cl_addr.sin_addr.s_addr & 0xFF) << 16),
				(uint8_t)((cl_addr.sin_addr.s_addr & 0xFF) << 24),
				cl_addr_len);

		pthread_create(&thr, NULL, thread_func, &cl_sock);
		pthread_detach(thr);
	}

	return 0;
}

