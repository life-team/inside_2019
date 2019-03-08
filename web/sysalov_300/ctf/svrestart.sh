#!/bin/bash

# separated by spaces
services="comet"

for service in $services; do
	sv restart $service
done
