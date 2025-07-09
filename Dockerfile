    FROM php:8.2-apache

# 1. Configuración inicial de Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    a2enmod rewrite

# 2. Instalar dependencias del sistema
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev && \
    docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip \
    mbstring \
    exif \
    gd

# 3. Configurar el directorio de trabajo
WORKDIR /var/www/html

# 4. Copiar solo lo necesario para instalar dependencias
COPY composer.json composer.lock ./

# 5. Instalar Composer (sin ejecutar scripts que requieran DB)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --no-scripts --optimize-autoloader

# 6. Copiar el resto de los archivos
COPY . .

# 7. Configurar permisos y optimización
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    php artisan storage:link

# 8. Configurar Apache para Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf && \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 9. Puerto expuesto
EXPOSE 80

# 10. Comando de inicio (las migraciones se ejecutarán aquí)
CMD ["sh", "-c", "php artisan migrate --force && docker-php-entrypoint apache2-foreground"]
