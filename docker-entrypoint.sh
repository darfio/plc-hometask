#!/bin/bash

set -e

# Check if the vendor directory exists
if [ ! -d "/var/www/html/vendor" ]; then
  composer install --no-progress --no-interaction --prefer-dist
  cp .env.example .env
else
  echo "Vendor directory found. Skipping composer install."
fi

if [ -f /var/www/html/artisan ]; then
    # Create storage directory if it doesn't exist
    mkdir -p /var/www/html/storage/framework/views
    mkdir -p /var/www/html/storage/framework/cache

    # Set proper permissions
    chown -R www-data:www-data /var/www/html/storage
    chown -R www-data:www-data /var/www/html/bootstrap/cache

    # Set permissions for the entire Laravel application
    find /var/www/html -type f -exec chmod 664 {} \;
    find /var/www/html -type d -exec chmod 775 {} \;

    # Artisan commands
    php artisan key:generate
    php artisan migrate --seed --force
else
    echo "Laravel application not detected. Skipping Laravel-specific commands."
fi

# Start PHP-FPM
php-fpm
