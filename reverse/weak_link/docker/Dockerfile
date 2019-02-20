FROM ubuntu:xenial
RUN apt update -y
RUN apt install -y tcpd xinetd
RUN useradd server
RUN echo "server 778/tcp" >> /etc/services
COPY config /etc/xinetd.d/server
COPY server /server
CMD service xinetd start && bash
