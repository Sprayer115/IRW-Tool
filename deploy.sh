#!/bin/bash

# Sicherstellen, dass das Skript Fehler abbricht
set -e

echo "Starting deployment with Docker..."
#git stash
# Pull latest changes from Git
echo "Pulling latest changes from git..."
#git pull origin main
cd ..
# Run Composer install/update inside the app container
echo "Running composer install/update in Docker..."
docker-compose exec app composer install --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations inside the app container
echo "Running database migrations in Docker..."
docker-compose exec app php artisan migrate --force
cd app
# Install or update npm packages inside the node container
echo "Installing npm dependencies in Docker..."
npm install

# Build assets for production inside the node container
echo "Building assets for production in Docker..."
npm run build
cd ..
# Clear caches inside the app container
echo "Clearing application cache in Docker..."
docker-compose exec app php artisan cache:clear

# Clear and optimize configuration inside the app container
echo "Optimizing configuration in Docker..."
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan config:cache

# Optimize routes and views inside the app container
echo "Optimizing routes and views in Docker..."
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Restart queue workers (if you use queues) inside the app container
echo "Restarting queue workers in Docker..."
docker-compose exec app php artisan queue:restart

echo "Deployment finished successfully!"
1~#!/bin/bash

# Sicherstellen, dass das Skript Fehler abbricht
set -e

echo "Starting deployment with Docker..."

# Pull latest changes from Git
echo "Pulling latest changes from git..."
git pull origin main

# Run Composer install/update inside the app container
echo "Running composer install/update in Docker..."
docker-compose exec app composer install --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations inside the app container
echo "Running database migrations in Docker..."
docker-compose exec app php artisan migrate --force

# Install or update npm packages inside the node container
echo "Installing npm dependencies in Docker..."
npm install

# Build assets for production inside the node container
echo "Building assets for production in Docker..."
npm run build

# Clear caches inside the app container
echo "Clearing application cache in Docker..."
docker-compose exec app php artisan cache:clear

# Clear and optimize configuration inside the app container
echo "Optimizing configuration in Docker..."
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan config:cache

# Optimize routes and views inside the app container
echo "Optimizing routes and views in Docker..."
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Restart queue workers (if you use queues) inside the app container
echo "Restarting queue workers in Docker..."
docker-compose exec app php artisan queue:restart

echo "Deployment finished successfully!"
