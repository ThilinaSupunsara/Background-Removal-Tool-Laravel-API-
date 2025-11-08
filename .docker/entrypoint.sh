#!/bin/sh

# Exit immediately if a command fails
set -e

# 1. Create the SQLite database file and set permissions
# This ensures the database file exists before migrations run.
touch /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite



# 3. Cache configuration for performance
php artisan config:cache
php artisan route:cache

# 4. Start the Apache web server
exec apache2-foreground
