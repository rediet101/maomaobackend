#!/bin/bash
set -e

# Cache configuration, routes, and views for production performance
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run database migrations automatically on startup
php artisan migrate --force || true

# Start Apache web server in foreground
exec apache2-foreground "$@"
