FROM phpdockerio/php74-fpm:latest

COPY app/composer.phar /usr/bin/composer

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip

RUN apt-get update \
    && apt-get  -y --no-install-recommends install  php7.4-mysql php7.4-xdebug php7.4-yaml

RUN apt-get -y update & apt-get -y install git

WORKDIR /var/www/html/app
