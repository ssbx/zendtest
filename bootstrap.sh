#!/bin/sh

rm -rf composer.phar
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
chmod -x composer.phar
php composer.phar install
php composer.phar development-enable

rm -f data/develdata.db
sqlite3 data/develdata.db < data/schema.sql

echo -n "
.PHONY: run test

run:
	php composer.phar run serve

test:
	php composer.phar run test

clean_all:
	rm -rf data/logs/* data/cache/* data/sessions/* data/tmp/*
	rm -rf temp data/develdata.db data/DoctrineORMModule/* vendor
	rm -f Makefile composer.lock composer.phar config/development.config.php

" > Makefile

printf "\n=> You can start the development server with \"make run\"\n"

