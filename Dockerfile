FROM php:8.2-apache

# Copy everything from repo root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Enable Apache mod_rewrite
RUN a2enmod rewrite

EXPOSE 80
CMD ["apache2-foreground"]
