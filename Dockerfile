# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# Install the 'mysqli' PHP extension (needed for database connections)
RUN docker-php-ext-install mysqli

# Enable Apache's mod_rewrite module, which is required for URL rewriting (common for routing and pretty URLs)
RUN a2enmod rewrite

# Set the Apache document root to the 'public' directory, which is where your app's public-facing files should reside
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache's default virtual host configuration to use the new document root path
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf  # Modify the default vhost configuration
