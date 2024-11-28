# Product Manager

Product Manager is a personal project to demonstrate a way to implement Symfony 7 as an API and VueJS 3 as a frontend to consume this API.

![Product Manager](https://github.com/CGSeb/product-manager/blob/main/imgs/mainimage.jpg?raw=true)

## Requirements
- Docker
- Make

## Install

In your development folder clone the repository
```
git clone https://github.com/CGSeb/product-manager.git
```

Copy the `.env.local` and remane it `.env`.

Run the init command
```
make init
```

## PG Admin

To access the PG Admin interface, visit [http://127.0.0.1:5000/](http://127.0.0.1:5000/). The login and password will be the environment variables you set in the `.env` (PGADMIN_EMAIL, PGADMIN_PASSWORD).

Once logged-in, click on `Add new server`, enter a name and switch to the `connection` tab. Enter the value you have in your `.env` for DATABASE_CONTAINER_NAME in the hostname, DATABASE_USER in the user and DATABASE_PASSWORD in the password. Click save and you should be logged-in.

## Main Commandes

- `make init` => create the needed folders for the application to work and start the installation
- `make start` / `make stop` / `make restart` => start, stop and restart the containers

## Dev Commandes

- `make bash` => enters into the PHP container bash
- `make composer-install` => run composer install in the PHP container
- `make composer-clear-cache` => run composer clear-cache in the PHP container
- `make composer-csi` => run composer csi in the PHP container. Used to execute the cs-fixer, phpstan analysis, load the test fixtures and the tests
- `make test-db` => create the database and tables (execute only if it's not already done)
- `make base-tables` => create the tables in the dev database
- `make load-base-data` => load the fixtures into the dev database. WARNING: it will drop the current database, re-create the tables and load the data