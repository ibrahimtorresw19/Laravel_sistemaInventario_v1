FROM php:8.2-apache

# 1. Instala dependencias + extensión pgsql
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        libpq-dev && \  # <- ¡Nuevo paquete para PostgreSQL!
    docker-php-ext-install pdo pdo_mysql pdo_pgsql zip  # <- Añade pdo_pgsql

# 2. Directorio de trabajo
WORKDIR /var/www/html

# 3. Copia el proyecto
COPY . .

# 4. Configuración de Laravel
RUN cp .env.example .env || echo ".env ya existe" && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    php artisan key:generate --force && \
    php artisan storage:link && \
    php artisan optimize

# 5. Puerto y comando
EXPOSE 80
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
