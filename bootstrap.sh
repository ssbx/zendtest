#!/bin/sh

composer self-update
composer install
composer development-enable

rm -f data/develdata.db
sqlite3 data/develdata.db < data/schema.sql

printf "\n=> You can start the development server with \"composer run serve\"\n"
