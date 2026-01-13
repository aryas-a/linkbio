#!/bin/sh
set -e

# Ensure required directories exist on the (possibly empty) mounted volume
mkdir -p \
  /var/www/html/storage/app/public \
  /var/www/html/storage/framework/cache \
  /var/www/html/storage/framework/sessions \
  /var/www/html/storage/framework/views \
  /var/www/html/bootstrap/cache

# Safe ownership
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Start services
php-fpm -D
nginx -g 'daemon off;'
