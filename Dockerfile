FROM php:8.3-fpm

## Versão da Lib do Redis para PHP
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

# Install PHP extensions with Postgres
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# Install and enable the Redis extension
RUN pecl install redis-${REDIS_LIB_VERSION} && docker-php-ext-enable redis

# Copy application code
COPY . /var/www

# Set permissions for specific directories
RUN chmod -R 755 /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Remove existing vendor directory and composer.lock
RUN rm -rf vendor composer.lock

# Copy the composer.json file
COPY composer.json /var/www/

# Run composer install with --ignore-platform-reqs
RUN composer install --no-scripts --ignore-platform-reqs
