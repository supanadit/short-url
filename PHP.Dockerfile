FROM php:7.4-cli

RUN apt-get update

RUN apt-get install -y git zip

RUN docker-php-ext-install pdo pdo_mysql

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /short

CMD [ "php", "artisan","serve" ,"--host","0.0.0.0"]