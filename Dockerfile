# Build and run the store as a single container.
FROM php:8.3-cli-alpine

# PHP extensions Laravel and this project need.
RUN apk add --no-cache \
        libzip-dev icu-dev oniguruma-dev sqlite-dev \
        libpng-dev libjpeg-turbo-dev freetype-dev \
        nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_sqlite mbstring zip bcmath intl gd opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Install PHP dependencies first so Docker can cache this layer.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --no-autoloader

# Then the front-end toolchain.
COPY package.json package-lock.json ./
RUN npm ci

COPY . .

# Build assets, then drop node_modules so the final image stays small.
RUN composer dump-autoload --optimize --no-dev \
    && npm run build \
    && rm -rf node_modules \
    && chmod +x docker/start.sh

# PHP's built-in server is single-threaded unless this is set.
ENV PHP_CLI_SERVER_WORKERS=4

EXPOSE 8000

CMD ["sh", "docker/start.sh"]
