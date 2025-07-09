FROM php:8.2-apache

# 1. Configuración inicial
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    a2enmod rewrite

# 2. Instalar dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip libpq-dev libpng-dev libonig-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring exif gd

# 3. Configurar directorio
WORKDIR /var/www/html

# 4. Copiar archivos necesarios para composer
COPY composer.json composer.lock ./

# 5. Instalar Composer (sin scripts)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --no-scripts --optimize-autoloader

# 6. Copiar todo el proyecto
COPY . .

# 7. Configurar Laravel
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    cp .env.example .env && \
    php artisan storage:link && \
    php artisan key:generate

# 8. Configurar Apache
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf && \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

EXPOSE 80

CMD ["sh", "-c", "php artisan migrate --force && php artisan cache:clear && php artisan view:clear && php artisan route:clear && docker-php-entrypoint apache2-foreground"]
