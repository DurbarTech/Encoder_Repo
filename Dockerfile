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

# Set locale (this avoids the update-locale command)
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen en_US.UTF-8

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip exif pcntl intl gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Optional: Ensure permissions (if needed)
RUN chown -R www-data:www-data /var/www/html

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
