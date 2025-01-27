# Imagen base con PHP 8.2 y Node.js para frontend
FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif bcmath gd zip \
    && apt-get clean

# Instalar Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar código fuente
COPY . .

# Instalar dependencias de Composer y npm
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build

# Establecer permisos para Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Exponer el puerto
EXPOSE 9000

# Comando de inicio
CMD ["php-fpm"]
