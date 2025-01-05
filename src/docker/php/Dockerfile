FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip unzip curl git libpq-dev libzip-dev netcat-openbsd librdkafka-dev wget gnupg software-properties-common \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && pecl install rdkafka redis \
    && docker-php-ext-enable rdkafka redis

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy environment file
RUN cp /var/www/html/docker/.env.docker /var/www/html/.env || true

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

# Build frontend assets
RUN npm install && npm run build

# Copy entrypoint script
COPY docker/entrypoint.sh /var/www/html/docker/entrypoint.sh

# Make entrypoint script executable
RUN chmod +x /var/www/html/docker/entrypoint.sh

# Install Kafka CLI tools
RUN wget -qO - https://packages.confluent.io/deb/7.2/archive.key | apt-key add - && \
    add-apt-repository "deb [arch=amd64] https://packages.confluent.io/deb/7.2 stable main" && \
    apt-get update && apt-get install -y confluent-community-2.13

# Start the application
CMD ["sh", "/var/www/html/docker/entrypoint.sh"]
