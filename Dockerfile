FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        dpkg-dev \
        libpng-dev \
        libjpeg-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        libzip-dev \
        zip \
        unzip \
        cron

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN docker-php-ext-configure gd \
  --enable-gd \
  --with-jpeg

ADD ./docker/services/php/php.ini /usr/local/etc/php/php.ini

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
#RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql mbstring exif pcntl bcmath gd sockets zip
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring gd zip

# Install NodeJS
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN groupadd --gid 1000 dev
RUN useradd -G www-data,root -s /bin/bash --uid 1000 --gid 1000 dev

RUN mkdir -p /home/dev/.composer && \
    chown -R dev:dev /home/dev

# Setting right timezone for container
RUN ln -snf /usr/share/zoneinfo/Europe/Moscow /etc/localtime && echo Europe/Moscow > /etc/timezone

# Setting right timezone for PHP
RUN printf "[PHP]\ndate.timezone = \"Europe/Moscow\"\n" > /usr/local/etc/php/conf.d/tzone.ini

# Set working directory
WORKDIR /var/www

USER dev

COPY --chown=dev:www-data ./src /src

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]