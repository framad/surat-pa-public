#!/bin/sh

set -e

cd /var/www/app_surat

echo "Setting Laravel permissions..."

mkdir -p \
    storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    /var/www/dok/keluar

chown -R www-data:www-data storage bootstrap/cache

find storage bootstrap/cache -type d -exec chmod 775 {} \;
find storage bootstrap/cache -type f -exec chmod 664 {} \;

echo "Setting upload directory permissions..."

chown -R www-data:www-data /var/www/dok

find /var/www/dok -type d -exec chmod 775 {} \;
find /var/www/dok -type f -exec chmod 664 {} \;

if [ ! -f "vendor/autoload.php" ]; then
    echo "vendor belum ada, menjalankan composer install..."

    composer install \
        --no-dev \
        --optimize-autoloader \
        --no-interaction
else
    echo "vendor sudah ada, skip composer install."
fi

exec php-fpm -F
