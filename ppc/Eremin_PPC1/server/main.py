import random
import multiprocessing
import socket
import time

def handle(connection, address):
    import logging
    logging.basicConfig(level=logging.DEBUG)
    logger = logging.getLogger("process-%r" % (address,))
    try:
        logger.debug("Connected %r at %r", connection, address)
        for dmg in range(1000):
            connection.send(b"Enter 'Yes' if this can be resolved.\nEnter 'No' if this cannot be resolved.\n\n")
            pyatn = [[1, 2, 3, 4], [5, 6, 7, 8], [9, 10, 11, 12], [13, 14, 15, 0]]
            alph2 = []
            k = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]
            for i in range(4):
                for d in range(4):
                    pyatn[i][d] = k[random.randint(0, len(k) - 1)]
                    k.remove(pyatn[i][d])
            for i in range(4):
                time.sleep(1)
                connection.send((str(pyatn[i][0]) + "\t" + str(pyatn[i][1]) + "\t" + str(pyatn[i][2]) + "\t" + str(pyatn[i][3]) + "\n").encode("utf-8"))
            k = 0
            ryad = 0
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
            print(ryad)
            if (ryad % 2 == 0):
                answer = "Yes\n"
            else:
                answer = "No\n"
            data = connection.recv(1024)
            if (data.decode("utf-8") != answer):
                connection.close()
                break
            if (dmg == 999):
                connection.send(b"CTF{ZGhfdlfCnfhfkcz}")
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
        self.socket.listen(1)

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
    server = Server("0.0.0.0", 33333)
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