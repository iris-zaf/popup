# Use PHP 8.3-FPM based on Debian
FROM php:8.3-fpm

# Install system dependencies required for compilation and PHP extensions
# - build-essential: provides make, gcc, g++
# - libssl-dev: OpenSSL development files (crucial for MongoDB's TLS)
# - pkg-config: helps find libraries during compilation
# - unzip: for extracting archives
# - autoconf: often necessary for PECL extensions to build correctly
# - openssl: the actual OpenSSL utility (ensures core OpenSSL is present)
# - zlib1g-dev & libzip-dev: Common dependencies for many PHP extensions including OpenSSL, sometimes missing
RUN apt-get update && apt-get install -y \
    build-essential \
    libssl-dev \
    pkg-config \
    unzip \
    autoconf \
    openssl \
    zlib1g-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/* 

# Enable the OpenSSL PHP extension by installing it via PECL (more robust for some base images)
# This explicitly builds and enables the openssl extension if docker-php-ext-install struggles.
# set -eux; will make the build fail immediately if this command errors.
RUN set -eux; \
    pecl install openssl; \
    docker-php-ext-enable openssl

# Install the MongoDB PHP extension using PECL
# This step builds the actual MongoDB driver.
# set -eux; will make the build fail immediately if this command errors.
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
# --no-dev: Skip development dependencies to reduce image size and build time
# --optimize-autoloader: Generate an optimized autoloader for faster runtime performance
RUN composer install --no-dev --optimize-autoloader

# Create upload folders & make them writable
# Permissions 777 are broad and generally not recommended for production,
# but used for simplicity in demos. For production, use more restrictive permissions.
RUN mkdir -p /app/public/uploads/images/popup \
    && chmod -R 777 /app/public/uploads \
    && chmod -R 777 /app/config

# Expose the port your PHP built-in server will listen on
EXPOSE 10000

# Define the command to run your PHP built-in web server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
