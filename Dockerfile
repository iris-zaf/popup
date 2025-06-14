# Use PHP 8.3-FPM based on Debian
FROM php:8.3-fpm

# Step 1: Install system packages
RUN apt-get update && apt-get install -y \
    build-essential \
    libssl-dev \
    pkg-config \
    unzip \
    autoconf \
    zlib1g-dev \
    libzip-dev \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    pecl install mongodb; \
    docker-php-ext-enable mongodb
RUN echo "upload_max_filesize=10M\npost_max_size=12M" > /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /app
COPY . /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p /app/public/uploads/images/popup \
    && chmod -R 777 /app/public/uploads \
    && chmod -R 777 /app/config

EXPOSE 8080
ENV PORT=8080
CMD php -S 0.0.0.0:${PORT:-8080} -t public
