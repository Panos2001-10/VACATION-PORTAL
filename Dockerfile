# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip mysqli

# Enable Apache's mod_rewrite module
RUN a2enmod rewrite

# Install Composer from the official Composer image
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Set the Apache document root to the 'public' directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache's default virtual host configuration
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf
