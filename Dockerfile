FROM php:8.2-apache

# 1. Instalación de dependencias
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip \
    mbstring \
    exif \
    gd \
    && a2enmod rewrite

# 2. Configuración del entorno
WORKDIR /var/www/html
COPY . .

# 3. Instalación de Laravel (sin migraciones)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    php artisan storage:link && \
    php artisan optimize

# 4. Puerto expuesto
EXPOSE 80

# 5. Comando de inicio (sin verificación de conexión)
CMD ["sh", "-c", "php artisan migrate --force && apache2-foreground"]
