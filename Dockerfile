FROM php:8.3-apache

# 1. Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    libpq-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 2. Clear apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Install required PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_sqlite pdo_pgsql mbstring exif pcntl bcmath gd

# 4. Enable Apache mod_rewrite
RUN a2enmod rewrite

# 5. Configure Apache Document Root to /public (Laravel standard)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Set working directory
WORKDIR /var/www/html

# 8. Copy application code into container
COPY . .

# 9. Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 10. Install Node dependencies and build frontend assets (Vite / Alpine.js)
RUN npm install \
    && npm run build \
    && rm -rf node_modules

# 11. Set proper permissions for Laravel's cache & storage
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# 12. Add our custom entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 13. Use the script to launch Apache on the Render-provided $PORT
CMD ["docker-entrypoint.sh"]
