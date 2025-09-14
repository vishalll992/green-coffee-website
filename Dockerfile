# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html/

# Copy the contents of "green coffee" into /var/www/html/
COPY ["green coffee/.", "/var/www/html/"]

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Fix permissions to avoid 403 Forbidden
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Add custom Apache config
COPY apache-config.conf /etc/apache2/conf-available/greencoffee.conf
RUN a2enconf greencoffee

# Expose port 80
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
