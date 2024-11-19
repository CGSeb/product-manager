EXEC = docker exec -it php-fpm
PHP = $(EXEC) php
COMPOSER = $(EXEC) composer
SYMFONY_CONSOLE = $(PHP) bin/console

# Colors
GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"


init:
	$(MAKE) create-folders
	$(MAKE) build
	$(MAKE) start

create-folders:
	mkdir -p ./app ./data/postgres ./logs/nginx

# ------------------------------ DOCKER ------------------------------
build:
	docker-compose build

start:
	docker-compose up -d
	@$(call GREEN,"The application is available at: http://127.0.0.1:8081/.")
	@$(call GREEN,"The Pgadmin is available at: http://127.0.0.1:5000/.")

stop:
	docker-compose stop
	@$(call RED,"Containers stopped.")

restart:
	$(MAKE) stop
	$(MAKE) start

