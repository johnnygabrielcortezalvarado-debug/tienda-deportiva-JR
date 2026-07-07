FROM php:8.2-apache

# Desinstalar y purgar completamente mpm_event para evitar conflictos de múltiples MPM en Apache
RUN apt-get update && apt-get purge -y apache2-mpm-event || true \
    && apt-get install -y apache2-mpm-prefork || true \
    && a2enmod mpm_prefork

# Instalar las extensiones de MySQLi y PDO
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar reescritura de URLs para tu MVC
RUN a2enmod rewrite

# Copiar el código del proyecto al servidor web
COPY . /var/www/html/