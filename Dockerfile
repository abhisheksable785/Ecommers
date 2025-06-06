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
    gnupg \
    ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# ✅ Install Node.js and npm (Recommended: Node 18 LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy all project files
COPY . .

# Ensure .env exists
RUN cp .env.example .env || true

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# ✅ Install Node dependencies and build assets
RUN npm install && npm run build

# Set correct permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Expose Laravel port
EXPOSE 8000

# Start the Laravel application with setup
CMD bash -c "\
    if [ ! -f .env ]; then cp .env.example .env; fi && \
    if ! grep -q ^APP_KEY= .env; then php artisan key:generate; fi && \
    php artisan config:cache && \
    php artisan storage:link && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=\$PORT"

