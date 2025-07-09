FROM php:8.2-apache

# 1. Instalación de dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    netcat \
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

# 3. Instalación y configuración de Laravel
RUN cp .env.example .env && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    php artisan key:generate --force && \
    php artisan storage:link && \
    php artisan optimize

EXPOSE 80

# Comando de inicio que ejecuta migraciones y luego Apache
CMD bash -c "while ! nc -z $DB_HOST $DB_PORT; do sleep 1; done && php artisan migrate --force && apache2-foreground"
