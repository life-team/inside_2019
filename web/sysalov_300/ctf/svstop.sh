#!/bin/bash

# separated by spaces
services="comet"

for service in $services; do
	sv d $service
	sleep 1
	sv status $service
done
