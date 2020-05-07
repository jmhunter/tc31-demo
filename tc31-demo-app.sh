#!/bin/bash

# Remove if already found
docker stop tc31-demo-app
docker rm tc31-demo-app
docker rmi jmhunter/tc31-demo-app

# Create new image
docker build -t jmhunter/tc31-demo-app . && \
docker run --name tc31-demo-app -d \
	--link tc31-demo-db \
	-e DB_HOSTNAME=tc31-demo-db \
	-e DB_USERNAME=tc31user \
	-e DB_PASSWORD=tc31password \
	-e DB_DB=tc31-demo \
	-e RUNNING_HOSTNAME=`hostname` \
	-p 9092:80 \
	jmhunter/tc31-demo-app
