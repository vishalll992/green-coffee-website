# Use official PHP with Apache
FROM php:8.2-apache

# Copy all project files into Apache’s root directory
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Enable Apache rewrite module (for clean URLs, optional)
RUN a2enmod rewrite
