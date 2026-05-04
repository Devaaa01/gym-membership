#!/bin/bash

echo "=== Environment Check ==="
echo "APP_ENV: $APP_ENV"
echo "DB_HOST: $DB_HOST"
echo "DB_PORT: $DB_PORT"
echo "DB_DATABASE: $DB_DATABASE"
echo "DB_USERNAME: $DB_USERNAME"
echo "MYSQL_ATTR_SSL_CA: $MYSQL_ATTR_SSL_CA"

echo "=== Fixing storage permissions ==="
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache
touch /var/www/html/storage/logs/laravel.log
chmod 666 /var/www/html/storage/logs/laravel.log

echo "=== Clearing old caches ==="
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "=== Running migrations ==="
php artisan migrate --force || echo "Migration failed - check DB connection"

# Seed only if users table is empty
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -1)
if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo "=== Seeding database ==="
    php artisan db:seed --force || echo "Seeding failed"
fi

echo "=== Creating storage symlink ==="
php artisan storage:link || true

echo "=== Caching for production ==="
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "=== Starting Apache ==="
apache2-foreground
