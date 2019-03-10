gcc source_code/server.c -lpthread -o server/server
gcc source_code/client.c -o src/client -fno-stack-protector -no-pie -m32 -O0 -g -static
