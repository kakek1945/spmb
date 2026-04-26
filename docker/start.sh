#!/bin/sh
set -eu

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.docker .env
fi

mkdir -p bootstrap/cache \
    database \
    storage/app/public \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views \
    storage/logs

touch database/database.sqlite

find bootstrap/cache -type f ! -name '.gitignore' -delete

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force --no-interaction
fi

php artisan package:discover --ansi
php artisan migrate --force --no-interaction
php artisan optimize:clear

exec php artisan serve --host=0.0.0.0 --port=8000
