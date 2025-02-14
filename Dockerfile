FROM php:8.2-apache

# Install any PHP extensions you need (e.g. mysqli, pdo_mysql)
RUN docker-php-ext-install mysqli

# Enable mod_rewrite if your app needs it
RUN a2enmod rewrite

# Point Apache’s DocumentRoot to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache’s default vhost to use that path
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf