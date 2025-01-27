FROM php:8.3.7-fpm-alpine

RUN apk add --no-cache linux-headers
RUN apk --no-cache upgrade && \
    apk --no-cache add bash git sudo openssh libxml2-dev oniguruma-dev autoconf gcc g++ make npm \
    freetype-dev libjpeg-turbo-dev libpng-dev libzip-dev ssmtp postgresql-dev

# PHP: Install php extensions
RUN pecl channel-update pecl.php.net
RUN pecl install pcov swoole

# Configurar y instalar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install mbstring xml pcntl gd zip sockets bcmath soap pgsql pdo pdo_pgsql
RUN docker-php-ext-enable mbstring xml gd zip pcov pcntl sockets bcmath soap swoole pgsql pdo pdo_pgsql

# Instalar extensión intl
RUN apk add icu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

WORKDIR /app
COPY . .

# Instalar dependencias
RUN composer install
RUN composer require laravel/octane spiral/roadrunner

# Configurar entorno
COPY .envDev .env
RUN mkdir -p /app/storage/logs
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Instalar y construir assets
RUN apk add --no-cache npm \
    && npm install \
    && npm run build

# Configurar Octane
RUN php artisan octane:install --server="swoole"

CMD php artisan octane:start --server="swoole" --host="0.0.0.0"
EXPOSE 8000