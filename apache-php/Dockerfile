FROM php:8.1-apache
# MySQL
RUN docker-php-ext-install mysqli
# Rewrite
RUN a2enmod rewrite
# Redis
RUN pecl install redis
RUN docker-php-ext-enable redis
RUN service apache2 restart
# Xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug