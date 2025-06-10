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

# Expose the port Render expects
EXPOSE 8080
ENV PORT=8080
# Start PHP built-in server using the dynamic Render PORT
CMD php -S 0.0.0.0:${PORT:-8080} -t public
