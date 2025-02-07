#!/bin/sh

mkdir -p bootstrap/cache storage/framework/{sessions,views,cache}
chmod -R 775 bootstrap/cache storage
chown -R www-data:www-data bootstrap/cache storage

php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache

exec "$@"
