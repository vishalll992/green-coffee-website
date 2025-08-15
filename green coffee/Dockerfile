# Use official PHP image with Apache
FROM php:8.2-apache

# Install PHP extensions (mysqli for MySQL)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy your project into the container's web root
COPY . /var/www/html/

# Give Apache permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Replace Apache's default port 80 with Render's dynamic $PORT
CMD ["bash", "-c", "sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf && apache2-foreground"]

# Expose the dynamic port
EXPOSE 10000
