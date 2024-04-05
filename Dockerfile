FROM php:8.3-fpm

## Version of Redis library for PHP
ARG REDIS_LIB_VERSION=6.0.2

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libhiredis-dev \
    libpq-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions with PostgreSQL
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# Install and enable the Redis extension
RUN pecl install redis-${REDIS_LIB_VERSION} && docker-php-ext-enable redis

# Set working directory
WORKDIR /var/www

# Copy application code
COPY . .

# Set broad permissions for the storage directory

RUN rm -rf storage/logs

RUN chmod u+x storage/

RUN chmod 777 storage/

RUN chown -R www-data:www-data storage/

# Get the latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Remove existing vendor directory and composer.lock
RUN rm -rf vendor composer.lock

# Copy the composer.json file
COPY composer.json .

# Copy SSL certificate and private key
COPY ./docker-compose/nginx/ssl/certificate.crt /etc/nginx/ssl/certificate.crt
COPY ./docker-compose/nginx/ssl/private.key /etc/nginx/ssl/private.key

# Run composer install with --ignore-platform-reqs
RUN composer install --no-scripts --ignore-platform-reqs

# Case disable nginx
# CMD php artisan serve --host=0.0.0.0 --port 9000
