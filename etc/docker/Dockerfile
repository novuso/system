FROM php:7.3-cli

RUN apt-get update \
    && apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
        zlib1g-dev \
        libicu-dev \
        g++ \
        locales \
        curl \
        git \
    && echo "en_US.UTF-8 UTF-8" >> /etc/locale.gen \
    && locale-gen en_US.UTF-8 \
    && dpkg-reconfigure --frontend=noninteractive locales \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install sockets \
    && rm -rf /var/lib/apt/lists/*
