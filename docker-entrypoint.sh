#!/bin/bash

# Automatically run database migrations FIRST.
# Extremely important: Laravel 11 uses the database for Cache and Sessions by default.
# We must create the 'cache' table BEFORE we run optimize:clear, or it will crash trying to clear a non-existent table!
php artisan migrate --force

# Now that the tables exist, safely run the cache optimizations
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Hand ownership of newly generated cache/log files back to Apache (www-data)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Render dynamically assigns a port via the $PORT environment variable.
# We must inject this port into Apache's config files before starting it.
if [ -z "$PORT" ]; then
    PORT=80
fi

sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Start Apache in the foreground
apache2-foreground
