import socket
import time

if __name__ == "__main__":
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.connect(("90.189.132.25", 33333))
    pyatn = [[1, 2, 3, 4], [5, 6, 7, 8], [9, 10, 11, 12], [13, 14, 15, 0]]
    while True:
        result = sock.recv(1024)
        print(result)
        for i in range(4):
            result = sock.recv(1024).decode("utf-8")[0:-1].split('\t')
            print(result)
            for d in range(4):
                pyatn[i][d] = int(result[d])
        k = 0
        alph2 = []
        for i in range(4):
            for j in range(4):
                if (pyatn[i][j] == 0):
                    ryad = i+1
                alph2.append(pyatn[i][j])
                k += 1
        for i in range(16):
            temp = 0
            for j in range(i+1, 16):
                if ((alph2[i] > alph2[j]) and (alph2[j] != 0)):
                    temp += 1
            ryad += temp
        print(alph2)
        if (ryad % 2 == 0):
            answer = b"Yes\n"
        else:
            answer = b"No\n"
        sock.send(answer)
    sock.close()