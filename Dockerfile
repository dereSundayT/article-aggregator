# Use PHP image with necessary extensions
FROM php:8.2-fpm

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    curl \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

RUN curl -sLo /usr/local/bin/wait-for-it https://github.com/vishnubob/wait-for-it/releases/download/v2.5.0/wait-for-it.sh \
    && chmod +x /usr/local/bin/wait-for-it

# Copy app files
COPY . .

RUN cp .env.example .env

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist

# Set permissions
RUN chown -R www-data:www-data /var/www


RUN php artisan key:generate
#RUN php artisan migrate

#RUN make setup

# Expose port
EXPOSE 8000

# Command to run Laravel's development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

#CMD ["sh", "-c", "wait-for-it mysql-db:3306 -- php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000"]
