FROM php:8.1-fpm-buster

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

# Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Node.js
RUN apt-get update && apt-get install -y curl && \
    curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - && \
    apt-get install -y nodejs

# 必要パッケージ（GDに必要なものも含む）
RUN apt-get install -y \
    git unzip libzip-dev libicu-dev libonig-dev \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install intl pdo_mysql zip bcmath gd

# php.ini
COPY ./php.ini /usr/local/etc/php/php.ini

WORKDIR /data
