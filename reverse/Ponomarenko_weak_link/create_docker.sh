#!/bin/bash
gcc server_side.c -o server/server
sudo docker build -t weak_link server/
