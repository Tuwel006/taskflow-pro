#!/bin/bash

# Ensure Laravel has a cache cleared environment on boot
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Automatically run database migrations if the database is configured
# --force is required to run migrations in the "production" environment
php artisan migrate --force

# Render dynamically assigns a port via the $PORT environment variable.
# We must inject this port into Apache's config files before starting it.
if [ -z "$PORT" ]; then
    PORT=80
fi

sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Start Apache in the foreground
apache2-foreground
