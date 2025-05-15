# Dockerfile für Laravel Backend mit PHP-FPM, Composer und Node.js (für Vite)

FROM php:8.2-fpm

# System- und PHP-Abhängigkeiten installieren
RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        npm \
        nodejs \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer installieren
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Arbeitsverzeichnis setzen
WORKDIR /var/www

# Abhängigkeiten kopieren und installieren
COPY backend/composer.json backend/composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

# Node-Module installieren (für Vite Build)
COPY backend/package.json backend/package-lock.json ./
RUN npm install

# Quellcode kopieren
COPY backend/ .

# Autoloader und Vite Build
RUN composer dump-autoload --optimize
# Optional: Vite Build für Produktion
# RUN npm run build

# Rechte setzen (optional, je nach Setup)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
