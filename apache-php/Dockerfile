FROM php:8.1-apache
RUN docker-php-ext-install mysqli
# Basic auth
RUN apt-get update
RUN apt-get install -y apache2-utils libaprutil1-dbd-mysql
RUN a2enmod authn_dbd
# Redis
RUN pecl install redis
RUN docker-php-ext-enable redis
RUN service apache2 restart
# Xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug