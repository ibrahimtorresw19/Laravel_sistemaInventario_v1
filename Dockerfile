FROM php:8.2-apache

# 1. Instala dependencias
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        && docker-php-ext-install pdo pdo_mysql zip

# 2. Directorio de trabajo
WORKDIR /var/www/html

# 3. Copia el proyecto (excepto lo ignorado en .dockerignore)
COPY . .

# 4. Configuración crítica (¡Aquí está la solución!)
RUN cp .env.example .env || echo ".env ya existe, continuando..." && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    php artisan key:generate --force && \
    php artisan storage:link && \
    php artisan optimize

# 5. Puerto y comando de inicio
EXPOSE 80
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
