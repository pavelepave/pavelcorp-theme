#!/bin/bash

FILE=$1
CONTAINER=$2
USER=$3
PASSWORD=$4
DATABASE=$5

read -p "Are you sure? " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    cat ${FILE} | docker exec -i ${CONTAINER} \
		/usr/bin/mysql \
		-u ${USER} \
		--password=${PASSWORD} \
		${DATABASE}
fi