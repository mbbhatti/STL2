FROM php:7.4-cli

WORKDIR /app

RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev zlib1g-dev libicu-dev libzip-dev g++ wget mariadb-client && \
    yes | pecl install xdebug && \
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini && \
    docker-php-ext-configure gd && \
    docker-php-ext-install bcmath exif gd gettext intl mysqli pdo_mysql sockets zip

COPY . /app
CMD .docker/test.sh
