.PHONY: run

run: data/develdata.db
	php -S localhost:8080 -t public


data/develdata.db:
	sqlite3 data/develdata.db < data/schema.sql
