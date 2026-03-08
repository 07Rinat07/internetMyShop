#!/bin/sh
set -e

cd /var/www/html

if [ ! -f vendor/autoload.php ]; then
  composer install --no-interaction --prefer-dist
fi

php artisan config:clear >/dev/null 2>&1 || true

exec php artisan serve --host=0.0.0.0 --port=8000
