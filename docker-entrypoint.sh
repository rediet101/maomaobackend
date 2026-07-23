#!/bin/bash
set -e

# Run artisan commands as root to ensure all Render environment variables are preserved
php artisan package:discover --ansi || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan migrate --force || true

# Ensure correct permissions and ownership on storage and bootstrap/cache (including generated cache/log files)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Start Apache web server in foreground
exec apache2-foreground "$@"
