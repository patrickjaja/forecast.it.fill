FROM php:8.1-rc-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# https://github.com/mlocati/docker-php-extension-installer#supported-php-extensions
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions amqp xdebug pdo_mysql @composer
