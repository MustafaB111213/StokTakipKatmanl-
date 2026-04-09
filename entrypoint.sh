#!/bin/sh
set -e

# .env yoksa .env.example'dan oluştur (GitHub'dan clone edilen makinelerde .env gelmez)
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Docker env var'larını .env dosyasına yaz
# (php artisan serve child process'leri .env'i re-read eder, OS env var'larını görmez)
sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION:-mysql}|" .env
sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST:-127.0.0.1}|" .env
sed -i "s|^DB_PORT=.*|DB_PORT=${DB_PORT:-3306}|" .env
sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE:-mini_stok_db}|" .env
sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME:-root}|" .env
sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD:-root}|" .env
sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=file|" .env
sed -i "s|^CACHE_STORE=.*|CACHE_STORE=file|" .env
sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=sync|" .env

php artisan config:clear
php artisan key:generate --force
php artisan migrate:fresh --seed --force
exec php artisan serve --host=0.0.0.0 --port=8000
