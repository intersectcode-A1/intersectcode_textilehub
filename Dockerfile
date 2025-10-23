# Gunakan image resmi PHP dengan composer dan ekstensi penting
FROM php:8.2-fpm

# Install dependency sistem dan ekstensi PHP penting
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory di dalam container
WORKDIR /var/www/html

# Copy file composer dulu (agar caching efisien)
COPY composer.json composer.lock ./

# Jalankan composer install (tanpa script artisan)
RUN composer install --no-scripts --no-autoloader --no-interaction --prefer-dist

# Copy semua source code project
COPY . .

# Jalankan dump autoload agar Laravel siap
RUN composer dump-autoload --optimize

# Permission untuk Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port PHP-FPM
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]
