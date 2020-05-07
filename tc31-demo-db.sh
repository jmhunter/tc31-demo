#!/bin/bash

# Remove if already found
docker stop tc31-demo-db
docker rm tc31-demo-db

# Create new image (we deliberately don't persist data here, as it's a demo)
docker run --name tc31-demo-db -d \
	-e MYSQL_DATABASE=tc31-demo \
	-e MYSQL_USER=tc31user \
	-e MYSQL_PASSWORD=tc31password \
	-e MYSQL_ROOT_PASSWORD=tc31secret \
	-v `pwd`/sql:/docker-entrypoint-initdb.d \
	mariadb
