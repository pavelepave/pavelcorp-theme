#!/bin/bash

DATE=$(date "+%Y_%m_%d_%H-%M-%S")
USER=$1
PASSWORD=$2
DATABASE=$3
HOST=$4
PREFIX=$5

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

mysqldump -u ${USER} -p${PASSWORD} \
					-h ${HOST} ${DATABASE} \
					--socket=/Applications/MAMP/tmp/mysql/mysql.sock \
					${PREFIX}postmeta \
					${PREFIX}posts \
					${PREFIX}terms \
					${PREFIX}term_relationships \
					${PREFIX}term_taxonomy \
					${PREFIX}termmeta \
					>> db_save_${DATABASE}_${DATE}.sql
