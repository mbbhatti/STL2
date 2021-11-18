# STL-2

## Requirements
- PHP >= 7.3.12
- symfony >= 4.4.x

## Installation 
Symfony utilizes composer to manage its dependencies. So, before using symfony, make sure you have composer installed on your machine. To download all required packages run a following commands or you can download [Composer](https://getcomposer.org/doc/00-intro.md).
- composer install `OR` COMPOSER_MEMORY_LIMIT=-1 composer install

## Database Setup
Need to set a .env file to make database connection with this setting.
```
DATABASE_URL=mysql://username:password@host:port/database_name
```

## Run
Use below command to start the project.
```
symfony server:start 
OR 
php -S 127.0.0.1:8000 -t public public/index.php
```

## Environment Variable

Application setting
```
- APP_ENV=Used to setup application environment like dev or test
- APP_SECRET=An application key based on 32 character alpha numeric string to secure the app
```

Database setting
```
- DATABASE_URL=It has url for database connection which includes username, password, port and name
```

Sentry setting
```
- SENTRY_DSN=A url to catch sentry errors
- SENTRY_ENVIRONMENT=Setup sentry environment, default is local
```

User authorization setting
```
- API_PASSWORD_HASH=Used for api authorization
- ADMIN_PASSWORD_HASH=Used for admin authorization
```

Admin or api password can be generated with this command.
```
php bin/console app:generate-password-hash {password}
```

Miscellaneous
```
- BASE_PATH=used in swagger.json to point file path
 ```
 
## Docker Environment
A Docker container is also available for development. Make sure you have installed docker on your machine before using docker. This Docker container launches an Apache server and serves this application with MariaDB. Now, time to make and run docker process as follows.

### Requirements
- .docker/dev.docker-compose.yml use to create docker images and containers
- .docker/dev.Dockerfile to handle php:7.4-apache configuration and setting
- .docker/vhost.conf use for application virtual host
- .docker/dev.docker-compose.yml uses MariaDB 10.4.13 to connect database with the setting of mysql://app:password@host:port/db for Docker.

### Build And Run Docker
The application needs to be build on the first launch like this (adjust path to your needs):
```
docker-compose -f .docker/dev.docker-compose.yml up --build
```
Afterwards, it can just be launched:
```
docker-compose -f .docker/dev.docker-compose.yml up
```
This Docker container launches an Apache server and serves this application. It is reachable under http://localhost:8080.

Docker images can also be login for testing, installation and database process with this.
```
docker-compose -f .docker/dev.docker-compose.yml exec SERVICENAME sh
```
