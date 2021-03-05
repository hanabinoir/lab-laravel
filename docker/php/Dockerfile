FROM php:7.3-apache

RUN apt-get update
RUN apt-get install -y zip vim
RUN docker-php-ext-install pdo_mysql

COPY php.ini $PHP_INI_DIR/conf.d/
COPY 000-default.conf /etc/apache2/sites-available/laravel.conf

RUN curl -sS https://getcomposer.org/installer | php \ 
&& mv composer.phar /usr/bin/composer
