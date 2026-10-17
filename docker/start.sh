#!/bin/sh
# Boot script for container hosts (Render, Fly, Railway...).
set -e

# Laravel refuses to boot without these directories.
mkdir -p database \
         storage/logs \
         storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views

# A missing APP_KEY crashes the app, so fall back to a throwaway one.
# Set APP_KEY in the host's environment to keep sessions alive across restarts.
if [ -z "$APP_KEY" ]; then
    APP_KEY="base64:$(head -c 32 /dev/urandom | base64)"
    export APP_KEY
    echo "WARNING: APP_KEY was not set - generated a temporary key for this boot."
fi

# Seed demo content the first time; afterwards only apply new migrations.
if [ ! -s database/database.sqlite ]; then
    echo "No database found - creating and seeding demo data."
    touch database/database.sqlite
    php artisan migrate --force --seed
else
    php artisan migrate --force
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
