# Multi-stage Dockerfile for Laravel Backend + React Frontend

# Stage 1: Build Frontend
FROM node:18-alpine AS frontend-builder

WORKDIR /app/frontend

# Copy frontend package files
COPY frontend/package*.json ./
RUN npm ci

# Copy frontend source and build
COPY frontend/ ./
RUN npm run build

# Stage 2: PHP Backend with Frontend Assets
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer from official image
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy backend composer files and install dependencies
COPY backend/composer.json backend/composer.lock ./
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --no-scripts --no-autoloader --optimize-autoloader

# Copy backend source code
COPY backend/ .

# Copy built frontend assets to Laravel public directory
COPY --from=frontend-builder /app/frontend/dist ./public/frontend

# Copy production environment file
COPY backend/.env.production .env

# Generate application key and optimize for production
RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Set permissions and create required directories
RUN mkdir -p /var/www/database /var/www/storage/logs /var/www/storage/framework/cache /var/www/storage/framework/sessions /var/www/storage/framework/views /var/www/bootstrap/cache && \
    touch /var/www/database/database.sqlite && \
    chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www/storage && \
    chmod -R 755 /var/www/bootstrap/cache && \
    chmod -R 755 /var/www/database

# Copy Docker configuration files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/startup.sh /usr/local/bin/startup.sh

# Make startup script executable
RUN chmod +x /usr/local/bin/startup.sh

# Create necessary directories
RUN mkdir -p /var/log/supervisor \
    && mkdir -p /run/nginx

# Expose port
EXPOSE 80

# Start with our startup script
CMD ["/usr/local/bin/startup.sh"]