# Build environment
# ===================================================================
FROM php:7.4 AS build
# Install git (requirement ofr composer install)
RUN apt-get update && apt-get install -y git zip
WORKDIR /app
# Copy source code
COPY . .
# Create .env and set production environment
RUN echo "APP_ENV=prod" > .env
# Remove unneeded files
RUN rm -rf .docker
# Copy composer executable from composer image
COPY --from=composer /usr/bin/composer /usr/bin/composer
# Install dependencies
RUN composer install --no-dev --optimize-autoloader


# Production environment
# ===================================================================
FROM alpine:3.13
LABEL org.opencontainers.image.source https://github.com/smartmobilefactory/ACUD-2-Backend

# Install apache2, PHP, and PHP modules
RUN apk add --update --no-cache \
    apache2 \
    php7-apache2 \
    php7 \
    php7-json \
    php7-curl \
    php7-xmlwriter \
    php7-xmlreader \
    php7-xml \
    php7-sodium \
    php7-sockets \
    php7-posix \
    php7-phar \
    php7-intl \
    php7-ftp \
    php7-exif \
    php7-fileinfo \
    php7-iconv \
    php7-openssl \
    php7-mcrypt \
    php7-mbstring \
    php7-dom \
    php7-pdo \
    php7-zip \
    php7-mysqli \
    php7-bcmath \
    php7-gd \
    php7-pdo_mysql \
    php7-gettext \
    php7-tokenizer \
    php7-ctype \
    php7-session \
    php7-simplexml && \
    # Enable rewrite module
    sed -i "s/#LoadModule\ rewrite_module/LoadModule\ rewrite_module/" /etc/apache2/httpd.conf

# Copy site configuration
COPY .docker/vhost.conf /etc/apache2/conf.d/000-default.conf
COPY .docker/additional_php.ini /etc/php7/conf.d/

# Copy source code and composer-installed packages from build stage
COPY --from=build /app /srv/app

# Set permissions
RUN chown -R apache:apache /srv/app && \
    chmod -R 775 /srv/app && \
    # Write logs to stdout and stderr
    ln -sf /dev/stdout /var/log/apache2/access.log && \
    ln -sf /dev/stderr /var/log/apache2/error.log

CMD ["httpd", "-DFOREGROUND"]
