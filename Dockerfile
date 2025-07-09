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
    php artisan key:generate --force

# 4. Crear tabla de sesiones si no existe
RUN if [ ! -f "database/migrations/*create_sessions_table.php" ]; then \
    php artisan session:table && \
    php artisan migrate --force; \
    fi

# 5. Ejecutar migraciones y optimización
RUN php artisan migrate --force && \
    php artisan storage:link && \
    php artisan optimize

# Configuración de Apache
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
EXPOSE 80
CMD ["apache2-foreground"]
