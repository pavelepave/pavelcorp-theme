#!/bin/bash

CONTAINER=$1

cat dump.local.sql | docker exec \
						-i ${CONTAINER} /usr/bin/mysql \
						-u wordpress \
						--password=wordpress \
						--default-character-set=utf8 \
						wordpress
