FROM php:8.2-apache

# Habilitar mpm_prefork y deshabilitar los otros para evitar conflictos
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork

# Instalar extensiones necesarias de MySQLi
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite
COPY . /var/www/html/