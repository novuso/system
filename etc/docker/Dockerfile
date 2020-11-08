FROM php:8.0-rc-cli

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
    && rm -rf /var/lib/apt/lists/*

RUN echo 'zend.assertions = 1' >> /usr/local/etc/php/conf.d/custom.ini \
    && echo 'assert.exception = 1' >> /usr/local/etc/php/conf.d/custom.ini
