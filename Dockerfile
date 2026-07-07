FROM php:8.2-apache

# Forzar la desactivación de otros MPM y limpiar conflictos de Apache
RUN a2dismod -f mpm_event mpm_worker || true \
    && a2enmod mpm_prefork

# Instalar extensiones de MySQLi y PDO
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite
COPY . /var/www/html/