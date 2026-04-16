FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    oniguruma-dev \
    icu-dev \
    libzip-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        intl \
        gd \
        zip \
        opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN addgroup -g 1000 appgroup && adduser -u 1000 -G appgroup -s /bin/bash -D appuser

RUN chown -R appuser:appgroup /var/www/html

USER appuser

EXPOSE 9000
