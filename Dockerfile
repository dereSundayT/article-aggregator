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

# Copy app files
COPY . .

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist

# Set permissions
RUN chown -R www-data:www-data /var/www


# Generate the Laravel encryption key
RUN php artisan key:generate

# Expose port
EXPOSE 8000

# Command to run Laravel's development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

