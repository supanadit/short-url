FROM php:7.4-apache

RUN apt-get update

# 1. development packages
RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libzip-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++

# Set Apache Root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Some Apache Mod
RUN a2enmod rewrite headers

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy Source Code
COPY .env.docker /var/www/html/.env
COPY . /var/www/html

# Change Working Directory
WORKDIR /var/www/html

# Composer install and generate key
RUN composer install && php artisan key:generate

RUN chown -R www-data:www-data /var/www/html