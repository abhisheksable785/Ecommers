# Use PHP 8.2 image with common extensions
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy your Laravel project files into the container
COPY . .

# Install PHP dependencies via Composer
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions
RUN chmod -R 755 /var/www && chown -R www-data:www-data /var/www

# Generate Laravel app key
RUN php artisan key:generate

# Expose the port Laravel will run on
EXPOSE 8000

# Start the Laravel application
CMD php artisan serve --host=0.0.0.0 --port=8000
