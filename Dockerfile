FROM dunglas/frankenphp:php8.2-bookworm

ARG CACHEBUST=1

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libicu-dev \
    && docker-php-ext-install intl zip pdo pdo_mysql \
    && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-scripts --no-interaction

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R a+rw storage

EXPOSE 8080

RUN php artisan config:clear

CMD sh -c "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"