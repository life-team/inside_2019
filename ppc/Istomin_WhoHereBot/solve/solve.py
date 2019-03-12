import socket


####################
HOST = '0.0.0.0'
PORT = 13453
OUTPUT = True
####################

def get_spliter(a):
    spliter = [(0, 0)]
    for j in range(len(a[0]) - 1 ):
        new = True
        for i in range(len(a) - 1):
            if a[i][j] == '#':
                new = False
        if new:
            spliter.append((spliter[-1][1], j))
    spliter.append((spliter[-1][1], len(a[0]) - 1))
    return spliter[2:]

def get_string(a, spliter):
    answer = []
    for k in spliter:
        for i in range(len(a) - 1):
            for j in range(k[0], k[1]):
                print(a[i][j], end='')
            print()

if __name__ == '__main__':
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
        s.connect((HOST, PORT))
        data = s.recv(10001)  # Получаем все переходы на новую линию
        print(data)
        data = s.recv(17)  # Получаем заголовок
        print(data)
        data = s.recv(371)  # Получаем капчу
        print(data)

    a = data.decode().split('\n')
    for i in range(len(a) - 1):
        for j in range(len(a[0]) - 1):
            print(a[i][j], end='')
        print()
    spliter = get_spliter(a)
    print(spliter)
    get_string(a, spliter)


