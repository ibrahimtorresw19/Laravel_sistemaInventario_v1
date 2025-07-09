FROM php:8.2-apache

# Instala dependencias del sistema y PHP
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        && docker-php-ext-install pdo pdo_mysql zip

# Directorio de trabajo
WORKDIR /var/www/html

# Copia todo el proyecto al contenedor
COPY . .

# Instala Composer y dependencias de Laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache && \
    php artisan key:generate --force && \
    php artisan storage:link && \
    php artisan optimize

# Puerto y comando de inicio
EXPOSE 80
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]