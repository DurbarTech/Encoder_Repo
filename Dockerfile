FROM php:8-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    vim \
    ffmpeg \
    libzip-dev \
    default-mysql-client \
    libicu-dev \  
    && rm -rf /var/lib/apt/lists/*  # Clear cache after installation

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip exif pcntl intl \  
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
