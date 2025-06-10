# Use PHP 8.3-FPM based on Debian
FROM php:8.3-fpm

# Install system dependencies required for compilation and PHP extensions
RUN apt-get update && apt-get install -y \
    build-essential \
    libssl-dev \
    pkg-config \
    unzip \
    autoconf \
    zlib1g-dev \
    libzip-dev \
    && docker-php-source extract \
    && docker-php-ext-install openssl \
    && docker-php-source delete \
    && rm -rf /var/lib/apt/lists/*

# Install the MongoDB PHP extension using PECL
RUN set -eux; \
    pecl install mongodb; \
    docker-php-ext-enable mongodb

# Set working directory inside the container
WORKDIR /app

# Copy your application files into the container
COPY . /app

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Run Composer to install your PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Create upload folders & make them writable
RUN mkdir -p /app/public/uploads/images/popup \
    && chmod -R 777 /app/public/uploads \
    && chmod -R 777 /app/config

# Expose the port your PHP built-in server will listen on
EXPOSE 10000

# Define the command to run your PHP built-in web server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
