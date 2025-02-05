# Usa PHP con FPM
FROM php:8.2-fpm

# Evitar interacción
ARG DEBIAN_FRONTEND=noninteractive

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip git curl libpng-dev libonig-dev libxml2-dev zip \
    libpq-dev supervisor nginx nodejs npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Copiar Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www

# Copiar código de la aplicación
COPY . .

# Instalar dependencias de Laravel y Node
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build && rm -rf node_modules

# Generar clave de Laravel
RUN php artisan key:generate

# Optimizar Laravel
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Configurar permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Configurar Nginx
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# Exponer puertos
EXPOSE 80
RUN mkdir -p bootstrap/cache storage/framework/{sessions,views,cache} \
    && chmod -R 775 bootstrap/cache storage \
    && chown -R www-data:www-data bootstrap/cache storage

# Comando de inicio
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
