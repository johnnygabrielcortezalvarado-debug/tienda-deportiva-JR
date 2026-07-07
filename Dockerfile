FROM php:8.2-cli

# Instalar la extensión mysqli y pdo necesarias para tu base de datos
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar todo tu proyecto al contenedor
COPY . /app
WORKDIR /app

# Exponer el puerto que asigna Railway e iniciar el servidor embebido de PHP
EXPOSE 8080
CMD ["php", "-S", "0.0.0.0:8080", "index.php"]