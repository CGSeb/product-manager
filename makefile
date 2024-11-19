EXEC = docker exec -it php-fpm
EXEC_FRONT = docker exec -it php-fpm
PHP = $(EXEC) php
COMPOSER = $(EXEC) composer
NPM = $(EXEC_FRONT) npm
SYMFONY_CONSOLE = $(PHP) bin/console

# Colors
GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"


init:
	$(MAKE) create-folders
	$(MAKE) build
	$(MAKE) start
	$(MAKE) composer-install
	$(MAKE) generate-keys

create-folders:
	mkdir -p ./data/postgres ./logs/nginx

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

# ------------------------------ COMPOSER ------------------------------
composer-install:
	$(COMPOSER) install

composer-update:
	$(COMPOSER) update

composer-clear-cache:
	$(COMPOSER) clear-cache

# ------------------------------ OTHER ------------------------------

generate-keys:
	$(SYMFONY_CONSOLE) lexik:jwt:generate-keypair