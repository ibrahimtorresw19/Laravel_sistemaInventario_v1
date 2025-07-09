# Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# 1. Instalación de dependencias (formato correcto)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# 2. Instalación de extensiones PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip \
    mbstring \
    exif \
    gd \
    && a2enmod rewrite

# 3. Configuración del directorio
WORKDIR /var/www/html

# 4. Copia del proyecto
COPY . .

# 5. Configuración de Laravel
RUN cp .env.example .env && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    php artisan key:generate --force && \
    php artisan session:table && \
    php artisan migrate --force && \
    php artisan storage:link && \
    php artisan optimize

# 6. Puerto y comando
EXPOSE 80
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]