#!/bin/bash

# separated by spaces
services="comet"

for service in $services; do
sv u $service
sleep 1
sv status $service
done
