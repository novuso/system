FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
        wget \
        curl \
        git \
        libxml2-dev \
        libssl-dev \
        libzip-dev \
    && docker-php-ext-install phar \
    && docker-php-ext-install simplexml \
    && docker-php-ext-install zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /vat/tmp/*

RUN echo 'zend.assertions = 1' >> /usr/local/etc/php/conf.d/custom.ini \
    && echo 'assert.exception = 1' >> /usr/local/etc/php/conf.d/custom.ini \
    && echo 'xdebug.mode = coverage' >> /usr/local/etc/php/conf.d/custom.ini
