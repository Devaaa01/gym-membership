#!/bin/bash

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link || true

# Cache config, routes, views for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
apache2-foreground
