
FROM php:8.3-fpm


RUN apt-get update && apt-get install -y \
    build-essential \
    libssl-dev \
    unzip \
    pkg-config # pkg-config is often needed for compiling extensions

# Install the MongoDB PHP extension using PECL (PHP Extension Community Library)
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb


# Set working directory inside the container
WORKDIR /app

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Run Composer to install your PHP dependencies
RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p /app/public/uploads/images/popup \
    && chmod -R 777 /app/public/uploads \
    && chmod -R 777 /app/config


EXPOSE 10000

# Define the command to run your PHP built-in web server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
