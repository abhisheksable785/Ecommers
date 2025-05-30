# Use PHP 8.2 FPM base image
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
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
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app code
COPY . .

# Create .env if not present
RUN cp .env.example .env || true

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Laravel commands
RUN php artisan key:generate && \
    php artisan config:cache && \
    php artisan route:cache

# Permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Expose Laravel port
EXPOSE 8000

# Start the server
CMD php artisan serve --host=0.0.0.0 --port=8000
