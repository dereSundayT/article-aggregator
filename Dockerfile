# Use PHP image with necessary extensions
FROM php:8.2-fpm

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    &&
