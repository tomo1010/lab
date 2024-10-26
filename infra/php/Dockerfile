FROM php:8.1-fpm-buster

ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

RUN apk update && apk add --no-cache \
    freetype-dev \ ←追加
    libjpeg-turbo-dev \ ←追加
    libpng-dev \ ←追加
  apt-get -y install --no-install-recommends git unzip libzip-dev libicu-dev libonig-dev && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \ ←追加
  docker-php-ext-install gd &&\ ←追加


COPY ./php.ini /usr/local/etc/php/php.ini

WORKDIR /data
