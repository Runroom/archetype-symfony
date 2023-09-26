FROM alpine:3.18 as fpm-base

ARG PHP_VERSION=82
ARG UID=1000
ARG USER=app

RUN apk add --no-cache \
    php${PHP_VERSION} \
    php${PHP_VERSION}-apcu \
    php${PHP_VERSION}-bz2 \
    php${PHP_VERSION}-ctype \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-dom \
    php${PHP_VERSION}-fileinfo \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-gd \
    php${PHP_VERSION}-iconv \
    php${PHP_VERSION}-intl \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-opcache \
    php${PHP_VERSION}-openssl \
    php${PHP_VERSION}-pcntl \
    php${PHP_VERSION}-pdo_pgsql \
    php${PHP_VERSION}-phar \
    php${PHP_VERSION}-posix \
    php${PHP_VERSION}-session \
    php${PHP_VERSION}-simplexml \
    php${PHP_VERSION}-sodium \
    php${PHP_VERSION}-tokenizer \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-xmlreader \
    php${PHP_VERSION}-xmlwriter \
    php${PHP_VERSION}-zip \
    git \
    fcgi \
    patch \
    postgresql-client \
    openssh

RUN ln -snf /usr/bin/php${PHP_VERSION} /usr/bin/php

RUN adduser -u $UID -D $USER

ENV PATH="/usr/app/vendor/bin:/usr/app/bin:${PATH}" \
    PHP_VERSION=${PHP_VERSION}

COPY .docker/app/base/healthcheck.sh /usr/local/bin/healthcheck
COPY .docker/app/base/60_extra.ini /etc/php${PHP_VERSION}/conf.d/
COPY .docker/app/base/www.conf /etc/php${PHP_VERSION}/php-fpm.d/
COPY .docker/app/base/entrypoint.sh /

RUN chmod +x /usr/local/bin/healthcheck
RUN chmod +x /entrypoint.sh

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

USER ${USER}

WORKDIR /usr/app

EXPOSE 9000

HEALTHCHECK CMD healthcheck

ENTRYPOINT ["/entrypoint.sh"]

FROM fpm-base as fpm-dev

ENV XDEBUG_MODE=off

USER root

RUN apk add --no-cache php${PHP_VERSION}-pecl-pcov --repository=https://dl-cdn.alpinelinux.org/alpine/edge/testing
RUN apk add --no-cache \
    php${PHP_VERSION}-pdo_sqlite \
    php${PHP_VERSION}-xdebug

COPY .docker/app/dev/61_extra.ini /etc/php${PHP_VERSION}/conf.d/

USER ${USER}

FROM node:18.18-alpine as node

WORKDIR /usr/app

RUN mkdir --parents public

COPY package*.json .
COPY *.config.js .
COPY .browserslistrc .
COPY .eslintrc.js .
COPY tsconfig.json .
COPY etc ./etc
COPY templates ./templates
COPY assets ./assets

RUN npm clean-install
RUN npm run build

FROM fpm-base as fpm-prod

USER root

COPY .docker/app/prod/61_extra.ini /etc/php${PHP_VERSION}/conf.d/

USER ${USER}

COPY --chown=$UID .env .
COPY --chown=$UID composer.json .
COPY --chown=$UID composer.lock .
COPY --chown=$UID symfony.lock .

RUN composer install --prefer-dist --no-progress --no-interaction --no-dev

COPY --chown=$UID . .

RUN composer dump-autoload --classmap-authoritative
RUN composer symfony:dump-env prod

RUN console cache:warmup
RUN console assets:install public

COPY --chown=$UID --link --from=node /usr/app/public public

FROM nginx:1.25-alpine as nginx-base

ARG UID=1000

RUN apk add --no-cache shadow

RUN usermod --uid $UID nginx

COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf

HEALTHCHECK CMD curl -f http://localhost || exit 1

FROM nginx-base as nginx-dev
FROM nginx-base as nginx-prod

COPY --chown=$UID --link --from=fpm-prod /usr/app/public /usr/app/public
