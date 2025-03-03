FROM php:8.1-fpm-buster

# 環境変数
ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

# Composer のインストール
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# パッケージの更新 & 必要なパッケージをインストール
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    nodejs \
    npm && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install gd

# php.ini を適用
COPY ./php.ini /usr/local/etc/php/php.ini

# 作業ディレクトリの設定
WORKDIR /data
