# Laravel Backend Dockerfile
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

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN COMPOSER_ALLOW_SUPERUSER=1 composer config -g secure-http false && \
    COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --no-scripts --optimize-autoloader --ignore-platform-reqs

# Copy application code
COPY . .

# Copy production environment file
COPY .env.production .env

# Generate Laravel key and optimize
RUN php artisan key:generate --force && \
    COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize --no-scripts

# Set permissions and create required directories
RUN mkdir -p /var/www/database /var/www/storage/logs /var/www/storage/framework/cache /var/www/storage/framework/sessions /var/www/storage/framework/views /var/www/bootstrap/cache && \
    touch /var/www/database/database.sqlite && \
    chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www/storage && \
    chmod -R 755 /var/www/bootstrap/cache && \
    chmod -R 755 /var/www/database

# Copy Docker configuration files (adapted for Debian)
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/startup.sh /usr/local/bin/startup.sh

# Remove default nginx site and enable our site
RUN rm -f /etc/nginx/sites-enabled/default && \
    ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Make startup script executable
RUN chmod +x /usr/local/bin/startup.sh

# Create necessary directories
RUN mkdir -p /var/log/supervisor && \
    mkdir -p /run/nginx && \
    mkdir -p /var/run

# Expose port
EXPOSE 80

# Start with our startup script
CMD ["/usr/local/bin/startup.sh"]