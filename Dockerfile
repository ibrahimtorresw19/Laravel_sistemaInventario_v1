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

# 4. Copiar los archivos de tu proyecto Laravel
COPY . .

# 5. Configurar Apache para Laravel
RUN cp .env.example .env && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    # Configurar el DocumentRoot de Apache para apuntar a /public
    sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf && \
    # Configurar AllowOverride para .htaccess
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 6. Instalar Composer y dependencias
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader

# 7. Puerto expuesto
EXPOSE 80

# 8. Comando de inicio
CMD ["sh", "-c", "php artisan migrate --force && docker-php-entrypoint apache2-foreground"]
