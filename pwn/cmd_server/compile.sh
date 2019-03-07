gcc src/server.c -lpthread -o bin/server
gcc src/client.c -o bin/client -fno-stack-protector -no-pie -m32 -O0 -g -static
