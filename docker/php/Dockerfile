FROM php:fpm

COPY ./docker/php/php.ini /usr/local/etc/php/

RUN apt-get update \
    && apt-get install -y default-mysql-client \
        zlib1g-dev \
        libzip-dev \
        unzip \
        libpq-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install \
        gd \
        pdo_mysql \
        zip \
    && apt-get -y install cron \
    && apt-get clean

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

WORKDIR /var/www

COPY ./docker/php/laravel-cron /etc/cron.d/laravel-cron

RUN chmod 0644 /etc/cron.d/laravel-cron \
    && crontab /etc/cron.d/laravel-cron

CMD ["sh", "-c", "cron && php-fpm"]
