FROM dunglas/frankenphp:php8.2-bookworm

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
```

**3. Atau coba ubah format `.env`** menjadi seperti ini:
```
CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME

CMD sh -c "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"