# Use PHP 8.2 with FPM
FROM php:8.2.12-fpm

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
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www

# Copy composer files separately for layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies (no dev)
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application files
COPY . .

# Set correct permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Expose Laravel port
EXPOSE 8000

# Start the Laravel application
CMD php artisan serve --host=0.0.0.0 --port=8000
