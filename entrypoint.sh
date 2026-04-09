#!/bin/sh
set -e

# Patch .env with Docker env vars so artisan serve child processes read correct values
sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST:-127.0.0.1}|" .env
sed -i "s|^DB_PORT=.*|DB_PORT=${DB_PORT:-3306}|" .env
sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE:-laravel}|" .env
sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME:-root}|" .env
sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD:-}|" .env

php artisan config:clear
php artisan key:generate --force
php artisan migrate:fresh --seed --force
exec php artisan serve --host=0.0.0.0 --port=8000
