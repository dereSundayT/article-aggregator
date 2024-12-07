# Use PHP image with necessary extensions
FROM php:8.2-fpm

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copy app files (including .env.example)
COPY . .

# Copy .env.example to .env if .env does not exist
RUN cp .env.example .env

# Install Laravel dependencies (composer install)
RUN composer install --no-interaction --prefer-dist

# Set permissions
RUN chown -R www-data:www-data /var/www

# Generate the Laravel encryption key
RUN php artisan key:generate

# Expose port
EXPOSE 8000

CMD ["php-fpm"]
