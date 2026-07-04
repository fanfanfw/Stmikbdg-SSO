FROM node:22-bookworm AS assets
WORKDIR /app
COPY package*.json ./
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi
COPY . .
RUN npm run build

FROM php:8.3-cli-bookworm
RUN apt-get update && apt-get install -y git unzip curl libpq-dev libzip-dev libicu-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev libonig-dev libcurl4-openssl-dev && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install pdo_pgsql pgsql zip intl bcmath gd mbstring curl exif pcntl && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts
COPY . .
COPY --from=assets /app/public/build ./public/build
RUN composer dump-autoload --optimize && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache && chmod -R ug+rwX storage bootstrap/cache
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
