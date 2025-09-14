FROM php:8.2-apache

# Copy only the contents of green coffee to /var/www/html
COPY green\ coffee/ /var/www/html/

WORKDIR /var/www/html/

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Enable mod_rewrite
RUN a2enmod rewrite

# Apache config to allow access
RUN echo '<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>' > /etc/apache2/conf-available/fix-permissions.conf \
    && a2enconf fix-permissions

EXPOSE 80
CMD ["apache2-foreground"]
