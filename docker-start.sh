#!/bin/bash

set -e

echo "=== Clearing old caches ==="
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "=== Generating APP_KEY ==="
    php artisan key:generate --force
fi

echo "=== Running migrations ==="
php artisan migrate --force

# Seed only if users table is empty (first deploy)
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -1)
if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo "=== Seeding database ==="
    php artisan db:seed --force
fi

echo "=== Creating storage symlink ==="
php artisan storage:link || true

echo "=== Caching for production ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Starting Apache ==="
apache2-foreground
