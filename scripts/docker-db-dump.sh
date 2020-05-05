#!/bin/bash

CONTAINER=$1
USER=$2
PASSWORD=$3
DATABASE=$4
PREFIX=$5

DATE=$(date "+%Y_%m_%d_%H-%M-%S")

printf "DELETE FROM ${PREFIX}postmeta;
DELETE FROM ${PREFIX}posts;
DELETE FROM ${PREFIX}terms;
DELETE FROM ${PREFIX}term_relationships;
DELETE FROM ${PREFIX}term_taxonomy;
DELETE FROM ${PREFIX}termmeta;


SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";
SET names 'utf8';
\n" > db_save_${DATABASE}_${DATE}.sql;

docker exec \
		-i ${CONTAINER} /usr/bin/mysqldump \
		-u ${USER} \
		--password=${PASSWORD} \
		--default-character-set=utf8 \
		--no-create-info \
		${DATABASE} \
		${PREFIX}postmeta \
		${PREFIX}posts \
		${PREFIX}terms \
		${PREFIX}term_relationships \
		${PREFIX}term_taxonomy \
		${PREFIX}termmeta \
		>> db_save_${DATABASE}_${DATE}.sql;

