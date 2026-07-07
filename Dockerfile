FROM php:8.2-apache

# Eliminar el archivo de configuración del evento MPM que causa el choque en Debian/Ubuntu
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.conf \
    && a2enmod mpm_prefork

# Instalar extensiones de MySQLi y PDO
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite
COPY . /var/www/html/