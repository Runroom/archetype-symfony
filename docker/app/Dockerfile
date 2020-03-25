FROM php:7.3-fpm-alpine

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN install-php-extensions apcu bz2 gd intl opcache pdo_mysql zip
RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

RUN apk --no-cache add bash git mysql-client

ENV PATH="/srv/app/vendor/bin:/srv/app/bin:${PATH}"

RUN composer global require hirak/prestissimo

WORKDIR /srv/app
