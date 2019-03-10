from pyfiglet import Figlet
import socket
import string


####################
HOST = '192.168.0.6'
PORT = 7777
OUTPUT = True
####################


def GenLetter():
    alphabet = {}
    alphabet_string = string.ascii_uppercase + string.digits
    settings = Figlet(font='4x4_offr')

    for letter in alphabet_string:
        alphabet.update({letter: settings.renderText(letter)})
    print(alphabet)


if __name__ == '__main__':
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
        s.connect((HOST, PORT))
        data = s.recv(10001)  # Получаем все переходы на новую линию
        data = s.recv(17)  # Получаем заголовок
        data = s.recv(371)  # Получаем капчу

    ascii_captcha = data.decode().rstrip()

    if OUTPUT:
        with open('bcaptcha.txt', 'w') as b:
            b.write(str(data))
        with open('captcha.txt', 'w') as c:
            c.write(ascii_captcha)



