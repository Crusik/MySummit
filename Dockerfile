FROM php:8.2-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    git curl libpng-dev libxml2-dev zip unzip libzip-dev oniguruma-dev \
    mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer - pin to specific version
COPY --from=composer:2.6.5 /usr/bin/composer /usr/bin/composer

# App
WORKDIR /var/www/html
COPY ./backend /var/www/html

# Update composer lock file and install Laravel deps
RUN composer update --no-dev --optimize-autoloader

# Permissions - more restrictive
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && chmod -R 775 /var/www/html/storage

USER www-data

CMD ["php-fpm"]