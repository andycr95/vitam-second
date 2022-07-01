FROM php:7.2-apache

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install mysqli pdo pdo_mysql

Run a2enmod rewrite

Run cp /root/vitam/env.example ./.env

RUN chmod 777 -R -c /var/www

