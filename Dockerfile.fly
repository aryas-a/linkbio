# Multi-stage build: Node for assets, Composer for PHP deps, final serversideup image with Nginx + PHP-FPM

# 1) Build assets
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.* ./
COPY tailwind.config.* ./
COPY postcss.config.* ./
RUN npm run build

# 2) Install PHP dependencies
FROM composer:2 AS composer_builder
WORKDIR /app
COPY composer.json composer.lock ./
# Copy full app to allow optimized autoloader generation
COPY . .
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader

# 3) Final runtime image with Nginx + PHP-FPM
FROM serversideup/php:8.3-fpm-nginx
WORKDIR /var/www/html

# Copy application code and dependencies
COPY --from=composer_builder /app .
# Copy Vite build artifacts
COPY --from=node_builder /app/public/build ./public/build

# Ensure necessary directories are writable
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Expose the default Nginx port used by the serversideup image
EXPOSE 8080

# Optional: Laravel optimizations at runtime are preferred (config:cache etc.)
# Use Fly release_command to run migrations.
