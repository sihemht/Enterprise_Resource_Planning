FROM php:8.2-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Nettoyage du cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP nécessaires pour MySQL
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Récupération de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www