FROM --platform=linux/arm64 php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    cron

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_mysql zip

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

#COPY cronjob /etc/cron.d/cronjob
# RUN chmod 0644 /etc/cron.d/cronjob

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/
