#!/bin/bash
cp bin/server docker/server && docker build -t cmd_server docker/
