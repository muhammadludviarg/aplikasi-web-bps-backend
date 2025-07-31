# --- STAGE 1: Build vendor ---
# Menggunakan image composer untuk install dependensi
FROM composer:2 as vendor

WORKDIR /app
# Salin hanya file composer untuk caching
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

# Install dependensi
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# --- STAGE 2: Final Image ---
# Menggunakan image PHP 8.2 dengan Apache Server
FROM php:8.2-apache

# Install ekstensi PHP yang umum dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
  && docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    zip \
    bcmath

# Atur DocumentRoot Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

# Salin file aplikasi dari lokal
COPY . /var/www/html

# Salin dependensi dari stage 'vendor'
COPY --from=vendor /app/vendor /var/www/html/vendor

# Atur permission untuk folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 untuk Apache
EXPOSE 80