#!/bin/sh

echo "Starting Laravel Portfolio Application..."

# Wait for database directory to be ready
mkdir -p /var/www/database
touch /var/www/database/database.sqlite

# Set proper permissions
chown -R www-data:www-data /var/www/database
chmod -R 755 /var/www/database

# Change to Laravel directory
cd /var/www

echo "Running database migrations..."
# Run Laravel migrations
php artisan migrate --force

echo "Seeding database..."
# Run database seeding (only if tables are empty)
php artisan db:seed --force

echo "Starting services..."
# Start supervisord
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
