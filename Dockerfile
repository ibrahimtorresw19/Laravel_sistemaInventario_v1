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
    netcat-openbsd && \
    docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip \
    mbstring \
    exif \
    gd && \
    a2enmod rewrite

# 2. Configuración del entorno
WORKDIR /var/www/html
COPY . .

# 3. Instalación y configuración de Laravel
RUN cp .env.example .env && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    php artisan storage:link && \
    php artisan optimize

# No ejecutamos migraciones aquí, se harán al iniciar el contenedor
EXPOSE 80

# Comando de inicio
CMD bash -c "php artisan migrate --force && apache2-foreground"
