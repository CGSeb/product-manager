ARG PHP_VERSION

# Use the official PHP FPM Alpine image
FROM php:8.2-fpm-alpine

# Install necessary packages
RUN apk update && \
    apk add --no-cache \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        git \
        nodejs \
        npm \
        bash \
        postgresql-dev \
        libsodium-dev \
        libzip-dev \
        pcre-dev ${PHPIZE_DEPS}\
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_pgsql sodium zip

RUN pecl install pcov && docker-php-ext-enable pcov

RUN apk del pcre-dev ${PHPIZE_DEPS}

# Clean up package cache
RUN rm -rf /var/cache/apk/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Set working directory
WORKDIR /var/www