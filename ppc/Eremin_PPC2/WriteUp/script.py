import socket
import resh

if __name__ == "__main__":
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.connect(("localhost", 9090))
    k = -1
    while True:
        alph2 = []
        result = sock.recv(1024)
        print(result)
        for i in range(4):
            result = sock.recv(1024).decode("utf-8")[0:-1].split('\t')
            print(result)
            for d in range(4):
                alph2.append(int(result[d]))
        if (k==-1):
            perem = resh.start(alph2)
            print(perem)
            k = len(perem)-1
        print(perem[len(perem)-k-1])
        print(k-1)
        sock.send(perem[len(perem)-k-1])
        k -= 1
    sock.close()