FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev \
    && mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache/data \
    && mkdir -p storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache \
    && chmod +x entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["sh", "entrypoint.sh"]
