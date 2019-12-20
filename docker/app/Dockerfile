FROM php:7.3-fpm-alpine

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions gd intl pdo_mysql zip opcache apcu
RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

RUN apk --no-cache add git bash

RUN wget https://getcomposer.org/installer -O - | php -- --install-dir=/usr/local/bin --filename=composer
RUN wget https://get.symfony.com/cli/installer -O - | bash

ENV PATH="/root/.symfony/bin:/srv/app/vendor/bin:/srv/app/bin:${PATH}"

WORKDIR /srv/app
