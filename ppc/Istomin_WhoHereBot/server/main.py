from pyfiglet import Figlet
import multiprocessing
import socket
import string
import random
import time

#  TODO: Из алфавита удалить буквы с разным размером

def CaptchaGenerate():
    alphabet = []
    #  forbidden_letters = ['I', 'M', 'W', '4', 'J', 'T']
    alphabet_string = string.ascii_uppercase + string.digits
    settings = Figlet(font='4x4_offr')

    #  Записываем все буквы из алфавита в список
    for letter in alphabet_string:
        alphabet.append(letter)

    #  (Костыль) Удаляем те символы, размер которых не 6х7
    #  for fletter in forbidden_letters:
    #      if alphabet.count(fletter):
    #          alphabet.remove(fletter)

    random.shuffle(alphabet)

    captchaString = ''.join(alphabet[:7])
    captcha = settings.renderText(alphabet[:7])
    return captcha, captchaString


def CaptchaHandler(connection, address):
    solved = 0
    while True:
        if solved != 5:
            captcha, captchaString = CaptchaGenerate()
            connection.sendall(b'\n' * 10000 + b'\t\t    ')
            connection.sendall(b'Solved:' + str(solved).encode() + b'/5\n\n')
            connection.sendall(captcha.encode())
            #  connection.sendall(b'\nANSWER:\n\n')
            print('{} captcha: {} - {}'.format(address, captchaString, solved))
        else:
            settings = Figlet(font='stop')
            connection.sendall(b'\n' * 10000 + settings.renderText('INSIDE CTF 2019').encode())
            connection.sendall(b'\n\t\t    Congratulations!\n\tSolved 5/5. Your flag: CTF{IS1XBAneiaYgPwX}\n\n\n\n')
            return

        data = connection.recv(32).decode().strip()

        if data and data.upper() in captchaString:
            solved += 1
        else:
            connection.sendall(b'\nSocket was closed...\n')
            connection.close()


def handle(connection, address):
    import logging
    logging.basicConfig(level=logging.DEBUG)
    logger = logging.getLogger("process-%r" % (address,))
    try:
        logger.debug("Connected %r at %r", connection, address)
        try:
            CaptchaHandler(connection, address)

            connection.close()
        except ConnectionResetError:
            pass
    except:
        logger.exception("Problem handling request")
    finally:
        logger.debug("Closing socket")
        connection.close()


class Server(object):
    def __init__(self, hostname, port):
        import logging

        self.logger = logging.getLogger("server")
        self.hostname = hostname
        self.port = port

    def start(self):
        self.logger.debug("listening")
        self.socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.socket.bind((self.hostname, self.port))
        self.socket.listen()

        while True:
            conn, address = self.socket.accept()
            self.logger.debug("Got connection")
            process = multiprocessing.Process(target=handle, args=(conn, address))
            process.daemon = True
            process.start()
            self.logger.debug("Started process %r", process)


if __name__ == "__main__":
    import logging
    logging.basicConfig(level=logging.DEBUG)
    server = Server("0.0.0.0", 13453)
    try:
        logging.info("Listening")
        server.start()
    except:
        logging.exception("Unexpected exception")
    finally:
        logging.info("Shutting down")
        for process in multiprocessing.active_children():
            logging.info("Shutting down process %r", process)
            process.terminate()
            process.join()
    logging.info("All done")
