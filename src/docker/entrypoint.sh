#!/bin/sh

chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "Waiting for database connection..."
while ! nc -z $DB_HOST 5432; do
  sleep 1
done

if [ ! -f .env ] || [ "$(stat -c %Y .env)" -lt "$(stat -c %Y docker/.env.docker)" ]; then
    echo "Copying .env.docker to .env"
    cp docker/.env.docker .env
fi

if ! grep -q "APP_KEY" .env || [ -z "$(grep APP_KEY .env | cut -d '=' -f2)" ]; then
  echo "Generating application key..."
  php artisan key:generate --force
fi

if [ ! -d "public/build" ]; then
  echo "Building frontend assets..."
  npm install
  npm run build
fi

echo "Running migrations and seeders..."
php artisan migrate --force
php artisan db:seed

echo "Creating storage link..."
php artisan storage:link

echo "Caching configuration and routes..."
php artisan config:cache
php artisan route:cache

chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "Starting PHP-FPM..."
php-fpm
