FROM php:8.2-apache

# Install mysqli and PDO extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www/html/

COPY ["green coffee/.", "/var/www/html/"]

RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

COPY apache-config.conf /etc/apache2/conf-available/greencoffee.conf
RUN a2enconf greencoffee

EXPOSE 80

CMD ["apache2-foreground"]
