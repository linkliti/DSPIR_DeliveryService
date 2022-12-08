FROM php:8.1-apache
RUN apt-get update
# MySQL
RUN docker-php-ext-install mysqli
# Composer
WORKDIR /var/www/
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer /usr/bin/composer /usr/local/bin/composer
# Composer utils
RUN apt-get install -y git unzip
# Alice (fixtures generator)
RUN composer require nelmio/alice
# JpGraph
COPY jpgraph.tar.gz /var/www/jpgraph.tar.gz
RUN tar -xzf jpgraph.tar.gz
# Rewrite
RUN a2enmod rewrite
# Redis
RUN pecl install redis
RUN docker-php-ext-enable redis
# Xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
# GD
RUN apt-get install -y libpng-dev
RUN docker-php-ext-install gd