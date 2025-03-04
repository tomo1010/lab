FROM php:8.1-fpm-buster

# 環境変数
ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

# Composer のインストール
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Node.js の公式リポジトリを追加し、LTS バージョンをインストール
RUN apt-get update && apt-get install -y curl && \
    curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - && \
    apt-get install -y nodejs && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install gd

# php.ini を適用
COPY ./php.ini /usr/local/etc/php/php.ini

# 作業ディレクトリの設定
WORKDIR /data
