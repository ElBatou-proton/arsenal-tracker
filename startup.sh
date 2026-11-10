#!/bin/sh

# Test that startup script is running
echo "=== STARTUP SCRIPT IS RUNNING ==="
echo "Current directory: $(pwd)"
echo "Files in current directory:"
ls -la

# Clear all cached files first
echo "Clearing all caches..."
rm -rf bootstrap/cache/*.php

# Wait for database to be ready
echo "Waiting for database connection..."
while ! php artisan db:show 2>/dev/null; do
    echo "Database not ready, waiting 8 seconds..."
    sleep 8
done

echo "Database is ready, running setup..."

# Fix permissions for volume mounts
echo "Fixing file permissions..."
# Ensure www-data user owns the critical directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public
# Set proper permissions - more permissive to handle any user ID issues
find /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public -type d -exec chmod 755 {} \;
find /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public -type f -exec chmod 644 {} \;
# Also ensure the entire /var/www/html is readable by anyone
chmod -R 755 /var/www/html

# Fresh migration to drop all tables and recreate them
echo "Running fresh migration to recreate all tables..."
php artisan migrate:fresh --force

# Verify critical tables exist
#echo "Verifying critical tables exist..."
#php artisan tinker --execute="echo Schema::hasTable('weapons') ? 'Weapons table exists' : 'Weapons table missing'; echo PHP_EOL;"
#php artisan tinker --execute="echo Schema::hasTable('ranks') ? 'Ranks table exists' : 'Ranks table missing'; echo PHP_EOL;"
#php artisan tinker --execute="echo Schema::hasTable('weapon_assignment_statuses') ? 'Weapon assignment statuses table exists' : 'Weapon assignment statuses table missing'; echo PHP_EOL;"
#php artisan tinker --execute="echo Schema::hasTable('weapon_assignments') ? 'Weapon assignments table exists' : 'Weapon assignments table missing'; echo PHP_EOL;"
#php artisan tinker --execute="echo Schema::hasTable('weapon_types') ? 'Weapon types table exists' : 'Weapon types table missing'; echo PHP_EOL;"

# Seed database with default data
echo "Seeding database with default data..."
php artisan db:seed --force

# Clear and regenerate caches
echo "Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Publish Filament translations to lang/vendor/filament/
echo "Publishing Filament translations..."
php artisan vendor:publish --tag=filament-translations --force

# Create vendor filament directories and copy custom translations
echo "Setting up custom translations..."
mkdir -p /var/www/html/lang/vendor/filament/es
# Copy custom Spanish translations to override Filament defaults
cp -r /var/www/html/lang/es/* /var/www/html/lang/vendor/filament/es/ 2>/dev/null || true

# Publish Livewire assets
echo "Publishing Livewire assets..."
php artisan livewire:publish --assets

# Debug: Check if admin routes are registered
echo "Checking admin routes..."
php artisan route:list | grep admin || echo "No admin routes found!"

# Debug: Check application status
echo "Checking application health..."
php artisan about || echo "About command failed"

# Debug: Check database connection
echo "Checking database connection..."
php artisan db:show || echo "Database check failed"

# Regenerate caches for production
echo "Regenerating caches for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Setup complete! Application is ready."
