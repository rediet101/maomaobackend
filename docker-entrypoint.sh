#!/bin/bash
set -e

# Ensure correct permissions on storage and bootstrap/cache before running commands
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Clear and rebuild cache for environment variables
su -s /bin/bash -c "php artisan config:clear" www-data || true
su -s /bin/bash -c "php artisan package:discover --ansi" www-data || true
su -s /bin/bash -c "php artisan config:cache" www-data || true
su -s /bin/bash -c "php artisan route:cache" www-data || true
su -s /bin/bash -c "php artisan view:cache" www-data || true
su -s /bin/bash -c "php artisan migrate --force" www-data || true

# Final permission check
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Start Apache web server in foreground
exec apache2-foreground "$@"
