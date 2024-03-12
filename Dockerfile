# Usamos una imagen base de PHP con Apache, compatible con Laravel
FROM php:8.2-apache

# Instalamos las extensiones necesarias para PHP
# y cualquier otra herramienta que necesites
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libicu-dev \
    g++ \
    autoconf \
    pkg-config \
    libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install -j$(nproc) gd mbstring exif pcntl bcmath zip

# Instalamos Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitamos el mod_rewrite para Apache
RUN a2enmod rewrite

# Configuramos el directorio raíz público de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instalamos Node.js y npm
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Copiamos la aplicación al contenedor
COPY . /var/www/html

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Instalamos las dependencias de Composer y npm
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install
RUN npm run dev &
RUN npm run build &

# Configuramos los permisos de los directorios de Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

EXPOSE 80

# Comando para iniciar Apache en el contenedor
CMD ["apache2-foreground"]
