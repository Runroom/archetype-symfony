FROM alpine:3.23 AS app-base

ARG PHP_VERSION=83
ARG UID=1000
ARG USER=app

COPY --from=caddy:2.10-alpine /usr/bin/caddy /usr/bin/caddy

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
    bash \
    git \
    patch \
    postgresql-client \
    openssh

RUN ln -snf /usr/bin/php${PHP_VERSION} /usr/bin/php

RUN adduser -u ${UID} -D ${USER}

ENV PATH="/usr/app/vendor/bin:/usr/app/bin:${PATH}" \
    PHP_VERSION=${PHP_VERSION}

COPY .docker/app/base/Caddyfile /
COPY .docker/app/base/60_extra.ini /etc/php${PHP_VERSION}/conf.d/
COPY .docker/app/base/www.conf /etc/php${PHP_VERSION}/php-fpm.d/
COPY .docker/app/base/entrypoint.sh /
COPY .docker/app/base/run.sh /

RUN chmod +x /entrypoint.sh
RUN chmod +x /run.sh

COPY --from=composer:2.9 /usr/bin/composer /usr/bin/composer

USER ${USER}

WORKDIR /usr/app

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]

FROM app-base AS app-dev

ENV XDEBUG_MODE=off

USER root

RUN apk add --no-cache php${PHP_VERSION}-pecl-pcov --repository=https://dl-cdn.alpinelinux.org/alpine/edge/community
RUN apk add --no-cache \
    php${PHP_VERSION}-pdo_sqlite \
    php${PHP_VERSION}-xdebug

COPY .docker/app/dev/61_extra.ini /etc/php${PHP_VERSION}/conf.d/

USER ${USER}

FROM node:20.19-alpine AS asset-builder

WORKDIR /usr/app

RUN mkdir --parents public

COPY package*.json .
COPY *.config.js .
COPY .browserslistrc .
COPY .eslintrc.js .
COPY tsconfig.json .
COPY templates ./templates
COPY assets ./assets

RUN npm clean-install
RUN npm run build

FROM app-base AS app-prod

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

COPY --chown=$UID --link --from=asset-builder /usr/app/public public
