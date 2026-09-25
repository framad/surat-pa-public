#!/bin/sh

set -e

cd /var/www/app_surat

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