# PHP_university_project﻿Docker Symfony Starter Kit
Starter kit is based on The perfect kit starter for a Symfony 4 project with Docker and PHP 7.2.
What is inside?
* Apache 2.4.25 (Debian)
* PHP 8.1 FPM
* MySQL 8.0.x (5.7)
* NodeJS LTS (latest)
* Composer
* Symfony CLI
* xdebug
* djfarrelly/maildev
Requirements
* Install Docker and Docker Compose on your machine
Installation
* (optional) Add
127.0.0.1   symfony.local
in your host file.
* Run build-env.sh (or build-env.ps1 on Windows box)

* Enter the PHP container:

docker-compose exec php bash
   * To install Symfony LTS inside container execute:
cd app
rm .gitkeep
git config --global user.email "you@example.com"
symfony new ../app --full --version=lts
chown -R dev.dev *
Container URLs and ports
   * Project URL
http://localhost:8000
or
http://symfony.local:8000
   * MySQL

      * inside container: host is mysql, port: 3306
      * outside container: host is localhost, port: 3307
      * passwords, db name are in docker-compose.yml
      * djfarrelly/maildev i available from the browser on port 8001

      * xdebug i available remotely on port 9000

      * Database connection in Symfony .env file:

DATABASE_URL=mysql://symfony:symfony@mysql:3306/symfony?serverVersion=5.7
Useful commands
         * docker-compose up -d - start containers
         * docker-compose down - stop contaniners
         * docker-compose exec php bash - enter into PHP container
         * docker-compose exec mysql bash - enter into MySQL container
         * docker-compose exec apache bash - enter into Apache2 container
