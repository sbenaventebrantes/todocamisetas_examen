#!/bin/sh
set -e

sleep 5

php artisan migrate --force
exec php artisan serve --host=0.0.0.0 --port=8000
