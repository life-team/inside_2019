#define _GNU_SOURCE
//#include <sys/types.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <pthread.h>
#include <stdio.h>
#include <string.h>
//#include <error.h>
#include <errno.h>
#include <inttypes.h>
#include <unistd.h>

#define PORT 0x0a03
#define BUF_SIZE 128

#define KEY "Super mega key123"
#define KEY_LEN 16

char *key = KEY;

int super_encrypt(char *message) {
	uint32_t i;

	for (i = 0; message[i]; ++i) {
		message[i] = message[i] ^ key[i % KEY_LEN];
	}
	message[i] = message[i] ^ key[i % KEY_LEN];
	return 0;
}

char *str_cpy(char *dst, char *src, uint32_t max) {
	uint32_t i;

	for (i = 0; i < max && src[i]; ++i)
		dst[i] = src[i];

	return dst + i;
}

int login(int sock) {
	int rc;
	int is_admin = 0;
	char password[BUF_SIZE];
	char login[BUF_SIZE];
	char message[BUF_SIZE*3];
	char *ptr;

	printf("login: ");
	scanf("%s", login);
	printf("password: ");
	scanf("%s", password);

	ptr = str_cpy(message, "/login/", 7);
	ptr = str_cpy(ptr, login, BUF_SIZE);
	*ptr = '/';
	++ptr;
	ptr = str_cpy(ptr, password, BUF_SIZE);
	*ptr = 0;
	++ptr;

	rc = send(sock, message, ptr - message, 0);
	if (rc == -1) {
		perror("send");
		return -1;
	}
	rc = recv(sock, message, BUF_SIZE*3, 0);
	if (rc == -1) {
		perror("recv");
		return -2;
	}

#if 0
	if (is_admin)
		printf("permit\n");
#endif

	if (strncmp(message, "ok", 2) == 0) {
		if (message[3] == '1')
			is_admin = 1;
	} else if (strcmp(message, "perm") == 0) {
		printf("Permission denied!");
		return -1;
	} else {
		printf("login fail!");
		return -1;
	}

	return is_admin;
}

void print_menu() {
	printf("main menu\n");
	printf("1) get flag\n");
	printf("2) command 1\n");
	printf("3) command 2\n");
	printf("4) command 3\n");
	printf("5) command 4\n");
	printf("\n0) exit\n");
}

void send_cmd(int socket, int is_admin, char *cmd) {
	int rv;
	char buf[4*BUF_SIZE];

	if (is_admin) {
		super_encrypt(cmd);
	}
	rv = send(socket, cmd, strlen(cmd), 0);
	if (rv < 0) {
		perror("send");
		return;
	}
	rv = recv(socket, buf, 4*BUF_SIZE, 0);
	if (rv < 0) {
		printf("timeout!\n");
		perror("recv");
		return;
	}
	printf("response: %s\n", buf);
}

void set_timeout(int sockfd) {
	struct timeval tv;

	tv.tv_sec = 3;
	tv.tv_usec = 0;
	setsockopt(sockfd, SOL_SOCKET, SO_RCVTIMEO, (const char*)&tv, sizeof tv);
}

int main() {
	int sock, rc, i, is_admin;
	struct sockaddr_in addr = { 0 };

	addr.sin_family = AF_INET;
	addr.sin_port = PORT;
#if 0
	addr.sin_addr.s_addr = htonl((127 << 24) | 1);
#else
	//90.189.132.25
	addr.sin_addr.s_addr = (90 | (189 << 8) | (132 << 16) | (25 << 24));
#endif

	sock = socket(AF_INET, SOCK_STREAM, 0);
	set_timeout(sock);
	rc = connect(sock, (struct sockaddr *)(&addr), sizeof(addr));
	if (rc < 0) {
		perror("connect");
		return -1;
	}

	is_admin = login(sock);
	if (is_admin < 0)
		return 0;

	while(1) {
		uint32_t ch;
		char cmd[20];

		print_menu();
		scanf("%u", &ch);
		if (ch == 0)
			break;
		else if (ch == 1) {
			strncpy(cmd, "/get_flag", 20);
			send_cmd(sock, is_admin, cmd);
		} else if (ch == 2) {
			strncpy(cmd, "/get", 20);
			send_cmd(sock, is_admin, cmd);
		} else if (ch == 3) {
			strncpy(cmd, "/time", 20);
			send_cmd(sock, is_admin, cmd);
		} else if (ch == 4) {
			strncpy(cmd, "/rcv", 20);
			send_cmd(sock, is_admin, cmd);
		} else if (ch == 5) {
			strncpy(cmd, "/snd", 20);
			send_cmd(sock, is_admin, cmd);
		}
		memset(cmd, 0, 20);
	}

	return 0;
}
