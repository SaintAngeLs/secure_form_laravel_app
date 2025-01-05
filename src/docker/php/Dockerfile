FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip unzip curl git libpq-dev libzip-dev netcat-openbsd \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN cp /var/www/html/docker/.env.docker /var/www/html/.env || true

RUN chmod -R 777 storage bootstrap/cache

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

RUN npm install && npm run build


COPY docker/entrypoint.sh /var/www/html/docker/entrypoint.sh

RUN chmod +x /var/www/html/docker/entrypoint.sh

CMD ["sh", "/var/www/html/docker/entrypoint.sh"]
