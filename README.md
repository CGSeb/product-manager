# Product Manager

Product Manager is a personal project to demonstrate a way to implement Symfony 7 as an API and XXXX as a frontend to consume this API.

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

