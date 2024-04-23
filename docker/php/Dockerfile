ARG COMPOSER_VERSION=2
ARG PHP_VERSION=8.3

FROM composer:$COMPOSER_VERSION AS composer
FROM php:${PHP_VERSION}-fpm

RUN apt-get update -y && apt-get install -y \
    openssl \
    git \
    unzip \
    libzip-dev

RUN docker-php-ext-install zip

WORKDIR /app

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
