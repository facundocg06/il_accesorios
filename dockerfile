FROM php:8.3.7-fpm-alpine

# Instalación de dependencias
RUN apk add --no-cache linux-headers
RUN apk --no-cache upgrade && \
    apk --no-cache add bash git sudo openssh libxml2-dev oniguruma-dev autoconf gcc g++ make npm \
    freetype-dev libjpeg-turbo-dev libpng-dev libzip-dev ssmtp postgresql-dev

# Extensiones PHP
RUN pecl channel-update pecl.php.net
RUN pecl install pcov swoole

# Configuración de extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install mbstring xml pcntl gd zip sockets bcmath soap pgsql pdo pdo_pgsql
RUN docker-php-ext-enable mbstring xml gd zip pcov pcntl sockets bcmath soap swoole pgsql pdo pdo_pgsql

# Extensión intl
RUN apk add icu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

WORKDIR /app
COPY . .

# Dependencias y optimizaciones
RUN composer install --optimize-autoloader --no-dev
RUN composer require laravel/octane spiral/roadrunner

# Configuración del entorno de producción
COPY .env.production .env

# Permisos y directorios
RUN mkdir -p /app/storage/logs
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# NPM y assets
RUN apk add --no-cache npm \
    && npm install \
    && npm run build \
    && npm cache clean --force

# Octane y optimizaciones Laravel
RUN php artisan octane:install --server="swoole"
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

CMD php artisan octane:start --server="swoole" --host="0.0.0.0" --workers=2 --task-workers=1
EXPOSE 8000