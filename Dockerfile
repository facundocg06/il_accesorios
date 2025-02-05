FROM php:8.2-fpm

# Argumentos para evitar interacción durante la instalación
ARG DEBIAN_FRONTEND=noninteractive

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libpq-dev \
    supervisor \
    nodejs \
    npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Copiar Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www

# Crear usuario y grupo www
RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

# Crear toda la estructura de directorios necesaria
RUN mkdir -p /var/www/bootstrap/cache \
    && mkdir -p /var/www/storage/framework/sessions \
    && mkdir -p /var/www/storage/framework/views \
    && mkdir -p /var/www/storage/framework/cache \
    && mkdir -p /var/www/storage/logs \
    && mkdir -p /var/www/vendor \
    && chown -R www:www /var/www \
    && chmod -R 775 /var/www

# Copiar archivos de la aplicación
COPY --chown=www:www . .

# Crear archivo .env si no existe
COPY --chown=www:www .env.example .env

# Configurar PHP-FPM para escuchar en TCP en lugar de socket Unix
RUN echo '[www]\n\
user = www\n\
group = www\n\
listen = 9000\n\
listen.owner = www\n\
listen.group = www\n\
listen.mode = 0660\n\
pm = dynamic\n\
pm.max_children = 5\n\
pm.start_servers = 2\n\
pm.min_spare_servers = 1\n\
pm.max_spare_servers = 3\n\
pm.max_requests = 500\n\
php_admin_value[error_log] = /var/log/fpm-php.www.log\n\
php_admin_flag[log_errors] = on\n\
php_admin_value[memory_limit] = 256M' > /usr/local/etc/php-fpm.d/www.conf

# Cambiar al usuario www
USER www

# Instalar dependencias de Composer
RUN composer install

# Generar clave de aplicación
RUN php artisan key:generate

# Limpiar y optimizar
RUN php artisan optimize:clear && \
    php artisan optimize

# Instalar y construir assets
RUN npm install && \
    npm run build && \
    rm -rf node_modules

# Asegurar permisos finales
USER root
RUN chown -R www:www /var/www/storage /var/www/bootstrap/cache

USER www

EXPOSE 9000

CMD ["php-fpm"]