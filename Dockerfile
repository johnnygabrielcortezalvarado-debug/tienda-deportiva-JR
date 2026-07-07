FROM php:8.2-apache

# Habilitar extensión mysqli de forma directa
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite para tu MVC
RUN a2enmod rewrite

# Ajustar el DocumentRoot o copiar archivos limpiamente
COPY . /var/www/html/

# Configurar Apache para escuchar en el puerto dinámico de Railway y evitar errores MPM
RUN sed -i -e 's/80/83/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf 2>/dev/null || true
ENV PORT=80
RUN sed -i -e 's/83/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf 2>/dev/null || true