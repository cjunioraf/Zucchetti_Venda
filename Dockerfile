FROM php:7.2-apache
# Instalar Node.js e npm
RUN apt-get update && apt-get install -y \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*
# Configurar diretório de trabalho
WORKDIR /www/app
# Instalar extensão PHP para MySQL
RUN docker-php-ext-install pdo_mysql



