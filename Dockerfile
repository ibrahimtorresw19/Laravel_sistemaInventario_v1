# Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# 1. Instalación de dependencias CRÍTICAS
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    libpq-dev \          # Driver PostgreSQL
    libpng-dev \         # Para procesamiento de imágenes
    libonig-dev \        # Para mbstring
    libxml2-dev \        # Para DOM XML
    && rm -rf /var/lib/apt/lists/*

# 2. Instalación de extensiones PHP ESENCIALES
RUN docker-php-ext-install \
    pdo \                # Base PDO
    pdo_mysql \          # MySQL
    pdo_pgsql \          # PostgreSQL (para sesiones)
    zip \                # Manipulación de ZIP
    mbstring \           # Strings multibyte
    exif \               # Metadatos de imágenes
    gd \                 # Manipulación de imágenes
    && a2enmod rewrite   # Habilita mod_rewrite

# 3. Configuración del directorio de trabajo
WORKDIR /var/www/html

# 4. Copia del proyecto (excluyendo lo del .dockerignore)
COPY . .

# 5. Configuración de Laravel (PASO A PASO)
RUN cp .env.example .env && \
    # Instalación de Composer
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    # Instalación de dependencias
    composer install --no-dev --optimize-autoloader --ignore-platform-reqs && \
    # Permisos
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    # Generación de clave
    php artisan key:generate --force && \
    # Configuración de sesiones
    php artisan session:table && \       # Crea migración de sesiones
    php artisan migrate --force && \     # Ejecuta TODAS las migraciones
    # Optimización
    php artisan storage:link && \
    php artisan optimize && \
    php artisan config:clear

# 6. Puerto y comando de inicio
EXPOSE 80
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]