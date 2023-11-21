# Use php:8.0-apache as the base image
FROM php:8.0-apache

# Update packages and install required dependencies
RUN apt-get update \
    && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PDO and MySQLi extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Install the MongoDB extension (use specific version, adjust as needed)
RUN pecl install mongodb-1.11.0 \
    && docker-php-ext-enable mongodb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Install MongoDB PHP library using Composer
RUN composer require mongodb/mongodb

# Expose port 80
EXPOSE 80