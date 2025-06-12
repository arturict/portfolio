# Multi-stage Dockerfile for Laravel Backend + React Frontend
# Using Debian-based images for better compatibility

# Stage 1: Build Frontend
FROM node:18 AS frontend-builder

WORKDIR /app/frontend

# Copy frontend package files
COPY frontend/package*.json ./

# Install dependencies with SSL workaround
RUN npm config set strict-ssl false && \
    npm ci --include=dev

# Copy frontend source and build
COPY frontend/ ./
RUN npm config set strict-ssl false && \
    npx tsc && npx vite build

# Stage 2: PHP Backend with Frontend Assets
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    sqlite3 \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer from official image
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy backend composer files and install dependencies
COPY backend/composer.json backend/composer.lock ./
RUN COMPOSER_ALLOW_SUPERUSER=1 composer config -g secure-http false && \
    COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --no-scripts --optimize-autoloader

# Copy backend source code
COPY backend/ .

# Copy built frontend assets to Laravel public directory
COPY --from=frontend-builder /app/frontend/dist ./public/frontend

# Copy production environment file
COPY backend/.env.production .env

# Generate application key and optimize for production without running scripts
RUN php artisan key:generate --force && \
    COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize --no-scripts

# Set permissions and create required directories
RUN mkdir -p /var/www/database /var/www/storage/logs /var/www/storage/framework/cache /var/www/storage/framework/sessions /var/www/storage/framework/views /var/www/bootstrap/cache && \
    touch /var/www/database/database.sqlite && \
    chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www/storage && \
    chmod -R 755 /var/www/bootstrap/cache && \
    chmod -R 755 /var/www/database

# Copy Docker configuration files (adapted for Debian nginx)
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/startup.sh /usr/local/bin/startup.sh

# Remove default nginx site and enable our site
RUN rm -f /etc/nginx/sites-enabled/default && \
    ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Make startup script executable
RUN chmod +x /usr/local/bin/startup.sh

# Create necessary directories for Debian
RUN mkdir -p /var/log/supervisor && \
    mkdir -p /run/nginx && \
    mkdir -p /var/run

# Expose port
EXPOSE 80

# Start with our startup script
CMD ["/usr/local/bin/startup.sh"]