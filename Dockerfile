FROM php:8.2-apache

# 1. Instalación de dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip \
    mbstring \
    exif \
    gd \
    bcmath \
    opcache \
    && a2enmod rewrite headers

# 2. Configuración de PHP y Apache
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    sed -i 's/memory_limit = .*/memory_limit = 512M/' "$PHP_INI_DIR/php.ini" && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 3. Configuración del entorno
WORKDIR /var/www/html

# 4. Copiar solo los archivos necesarios primero (optimización de caché)
COPY composer.json composer.lock ./

# 5. Instalar dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --no-interaction --optimize-autoloader

# 6. Copiar el resto de la aplicación
COPY . .

# 7. Configurar permisos y entorno Laravel
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    cp .env.example .env && \
    php artisan key:generate --force && \
    php artisan storage:link

# 8. Manejo de migraciones (solución robusta)
RUN set -e; \
    if ! ls database/migrations/*_create_sessions_table.php 1> /dev/null 2>&1; then \
        php artisan session:table; \
    fi && \
    php artisan migrate --force && \
    php artisan optimize:clear && \
    php artisan optimize

EXPOSE 80
CMD ["apache2-foreground"]
