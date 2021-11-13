FROM composer:2.1.12 as build
WORKDIR /var/www/html
COPY ./src /var/www/html
RUN composer install --optimize-autoloader --no-dev

FROM php:8.0-apache
EXPOSE 80
COPY --chown=www-data:www-data --from=build /var/www/html /var/www/html
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite headers