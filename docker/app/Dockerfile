FROM php:7.4-fpm-alpine

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN install-php-extensions apcu bz2 gd intl opcache pdo_mysql zip
RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

RUN apk --no-cache add bash git mysql-client openssh-client unzip

ENV PATH="/srv/app/vendor/bin:/srv/app/bin:${PATH}"

WORKDIR /srv/app
