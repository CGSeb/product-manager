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
	$(MAKE) test-db
	$(MAKE) base-tables
	$(MAKE) load-base-data

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

composer-clear-cache:
	$(COMPOSER) clear-cache

composer-csi:
	$(COMPOSER) csi

# ------------------------------ OTHER ------------------------------
bash:
	$(EXEC) bash

# ------------------------------ SYMFONY ------------------------------
generate-keys:
	$(SYMFONY_CONSOLE) lexik:jwt:generate-keypair

test-db:
	$(SYMFONY_CONSOLE) --env=test doctrine:database:create
	$(SYMFONY_CONSOLE) --env=test doctrine:schema:create

base-tables:
	$(SYMFONY_CONSOLE) doctrine:schema:create

load-base-data:
	$(SYMFONY_CONSOLE) doctrine:schema:drop --force
	$(SYMFONY_CONSOLE) doctrine:schema:create
	$(SYMFONY_CONSOLE) doctrine:fixtures:load -n