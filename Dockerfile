FROM php:8.2-apache

# 1. Configuración inicial
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    a2enmod rewrite

# 2. Instalar dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip libpq-dev libpng-dev libonig-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring exif gd

# 3. Configurar directorio de trabajo
WORKDIR /var/www/html

# 4. Copiar archivos
COPY . .

# 5. Configurar Laravel
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    cp .env.example .env && \
    # Configurar Apache para Laravel
    sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf && \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 6. Instalar dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader && \
    php artisan key:generate && \
    php artisan storage:link && \
    php artisan optimize:clear

EXPOSE 80

CMD ["sh", "-c", "php artisan migrate --force && docker-php-entrypoint apache2-foreground"]
