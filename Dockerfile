# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# 1. Instala dependencias del sistema
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        libpq-dev \       # Para PostgreSQL
        libpng-dev \      # Si usas imágenes/GD
        libonig-dev \     # Para mbstring
        libxml2-dev && \  # Para XML
    # Instala extensiones PHP necesarias
    docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \      # Driver PostgreSQL
        zip \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd && \
    # Habilita mod_rewrite de Apache
    a2enmod rewrite

# 2. Configura el directorio de trabajo
WORKDIR /var/www/html

# 3. Copia todo el proyecto (excepto lo especificado en .dockerignore)
COPY . .

# 4. Configuración de Laravel
RUN cp .env.example .env && \
    # Instala Composer
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    # Instala dependencias
    composer install --no-dev --optimize-autoloader && \
    # Permisos
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    # Configuración clave
    php artisan key:generate --force && \
    php artisan storage:link && \
    php artisan optimize && \
    php artisan config:cache

# 5. Puerto y comando de inicio
EXPOSE 80
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]