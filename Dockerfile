# ---- PHP 7 ----
FROM php:7.2-fpm

LABEL maintainer="Joseph Ian Farillas <jfarillas.dev@gmail.com>"

#Install dependencies
RUN apt-get update \
    && apt-get install -y sudo \
    && apt-get install -y systemd \
    && apt-get install -y iputils-ping \
    && apt-get install -y net-tools \
    && apt-get install -y git \
    && apt-get install -y libpng-dev \
    && apt-get install -y libicu-dev \
    && apt-get install -y libxml2-dev \
    && apt-get install -y libzip-dev \
    && apt-get install -y zlibc \
    && apt-get install -y zlib1g \
    && apt-get install -y libmemcached-dev \
    && apt-get install -y libmemcached11

RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install zip pdo pdo_mysql mysqli bcmath gd intl xml hash zip dom session opcache

RUN git clone https://github.com/php-memcached-dev/php-memcached /usr/src/php/ext/memcached \
  && cd /usr/src/php/ext/memcached && git checkout -b php7 origin/php7 \
  && docker-php-ext-configure memcached \
  && docker-php-ext-install memcached 

# Install Composer
RUN apt-get install -y curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PPA
RUN apt-get install -y software-properties-common

# Go to the current direcory
WORKDIR /usr/src/test-task-api

# Copy host directory to the Docker directory
COPY . .

# Install app dependencies
COPY composer.json .

# These following steps are intended on local development only
# Install Laravel dependencies
# RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
#     && composer dump-autoload

CMD [ "php", "-S", "0.0.0.0:8000", "-t", "public" ]
