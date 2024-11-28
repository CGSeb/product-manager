# Product Manager

Product Manager is a personal project that demonstrates a way to implement Symfony 7 as an API and VueJS 3 as a frontend to consume this API.

![Product Manager](https://github.com/CGSeb/product-manager/blob/main/imgs/mainimage.jpg?raw=true)

## Requirements
- Docker
- Make

## Install

In your development folder clone the repository
```
git clone https://github.com/CGSeb/product-manager.git
```

Copy the `.env.local` and rename it `.env`.

Run the init command
```
make init
```

## PG Admin

To access the PG Admin interface, visit [http://127.0.0.1:5000/](http://127.0.0.1:5000/). The login and password will be the environment variables you set in the `.env` (PGADMIN_EMAIL, PGADMIN_PASSWORD).

Once logged in, click `Add new server`, enter a name, and switch to the `connection` tab. Enter the value you have in your `.env` for DATABASE_CONTAINER_NAME in the hostname, DATABASE_USER in the user and DATABASE_PASSWORD in the password. Click save and you should be logged-in.

## Main Commands

- `make init` => creates the needed folders for the application to work and start the installation
- `make start` / `make stop` / `make restart` => starts, stops and restarts the containers

## Dev Commands

- `make bash` => enters into the PHP container bash
- `make composer-install` => runs composer install in the PHP container
- `make composer-clear-cache` => runs composer clear-cache in the PHP container
- `make composer-csi` => runs composer csi in the PHP container. Used to execute the cs-fixer, phpstan analysis, load the test fixtures and the tests
- `make test-db` => creates the database and tables (execute only if it's not already done)
- `make base-tables` => creates the tables in the dev database
- `make load-base-data` => loads the fixtures into the dev database. WARNING: it will drop the current database, re-create the tables and load the data
