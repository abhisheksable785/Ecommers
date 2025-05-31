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

# Copy all project files
COPY . .

# Ensure .env exists
RUN cp .env.example .env || true

# Install PHP dependencies without dev packages
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Set correct permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Expose Laravel port
EXPOSE 8000

# Start the Laravel application with setup
CMD bash -c "\
    if [ ! -f .env ]; then cp .env.example .env; fi && \
    if ! grep -q ^APP_KEY= .env; then php artisan key:generate; fi && \
    php artisan config:cache && \
    php artisan serve --host=0.0.0.0 --port=8000"