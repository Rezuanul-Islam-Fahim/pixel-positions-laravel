#!/bin/sh

set -e

echo "Starting Laravel Application..."

# Wait for database to be ready
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database to be ready..."
    until nc -z -v -w30 $DB_HOST ${DB_PORT:-3306}
    do
        echo "Waiting for database connection..."
        sleep 2
    done
    echo "Database is ready!"
fi

# Create storage directories if they don't exist
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Run Laravel optimizations
echo "Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Clear and cache again after migrations
php artisan config:cache

echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
