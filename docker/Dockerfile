FROM composer:latest as build
WORKDIR /app
COPY ../src /app
RUN composer install

FROM php:7.4-apache
EXPOSE 80
COPY --from=build /app /app
RUN chown -R www-data:www-data /app

ENV APACHE_DOCUMENT_ROOT=/app/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers