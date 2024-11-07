FROM php:8.3-fpm-alpine

LABEL maintainer="pablomesq"
LABEL email="pablomesquita@id.uff.br"

# Instalando extensões necessárias do PHP
RUN apk add --update --no-cache \
        linux-headers \
        alpine-sdk autoconf curl curl-dev freetds-dev \
        libxml2-dev jpeg-dev openldap-dev libmcrypt-dev \
        libpng-dev libxslt-dev postgresql-dev 
RUN docker-php-ext-configure ldap --with-ldap=/usr
RUN docker-php-ext-configure xml
RUN docker-php-ext-configure gd 
RUN docker-php-ext-install \
    pgsql pdo pdo_mysql pdo_pgsql

# Instalando o XDebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Instalando o Composer
RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/
COPY ./src/composer*.json .
RUN composer install
COPY ./src .

# User
RUN adduser -h /var/www \
    -s /sh \
    -D phpnginx
RUN chown phpnginx:phpnginx /var/www

USER phpnginx

EXPOSE 9000