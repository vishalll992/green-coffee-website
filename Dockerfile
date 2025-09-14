FROM php:8.2-apache

# Copy project files from "green coffee" folder into Apache root
COPY "green coffee/" /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Enable Apache rewrite (optional, if using .htaccess)
RUN a2enmod rewrite

EXPOSE 80
