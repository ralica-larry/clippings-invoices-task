FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    locales \
    git \
    unzip \
    zip \
    libzip-dev \
    zlib1g-dev \
    libpng-dev \
    curl

RUN docker-php-ext-install gd zip

RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN mv .env.example .env

RUN composer install
