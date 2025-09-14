FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www/html/

# Copy your project files
COPY ["green coffee/.", "/var/www/html/"]

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Apache config
COPY apache-config.conf /etc/apache2/conf-available/greencoffee.conf
RUN a2enconf greencoffee

EXPOSE 80
CMD ["apache2-foreground"]
