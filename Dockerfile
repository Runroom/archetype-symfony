# FPM-BASE
FROM alpine:3.17 as fpm-base

ARG PHP_VERSION=81
ARG UID=1000
ARG GID=1000
ARG USER=app
ARG GROUP=app

RUN apk add --no-cache \
    php${PHP_VERSION} \
    php${PHP_VERSION}-apcu \
    php${PHP_VERSION}-bz2 \
    php${PHP_VERSION}-ctype \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-dom \
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
    php${PHP_VERSION}-xmlwriter \
    php${PHP_VERSION}-zip \
    git \
    postgresql-client

RUN addgroup -g $GID $GROUP
RUN adduser -u $UID -D -G $GROUP $USER

ENV PATH="/usr/app/vendor/bin:/usr/app/bin:${PATH}" \
    PHP_VERSION=${PHP_VERSION}

COPY .docker/app-prod/extra.ini /etc/php${PHP_VERSION}/conf.d/extra.ini
COPY .docker/app-prod/www.conf /etc/php${PHP_VERSION}/php-fpm.d/www.conf

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

USER ${USER}

WORKDIR /usr/app

EXPOSE 9000
CMD php-fpm${PHP_VERSION}

# FPM-DEV
FROM fpm-base as fpm-dev

ENV XDEBUG_MODE=off

USER root

RUN apk add --no-cache php${PHP_VERSION}-pecl-pcov --repository=https://dl-cdn.alpinelinux.org/alpine/edge/testing
RUN apk add --no-cache \
    php${PHP_VERSION}-pdo_sqlite \
    php${PHP_VERSION}-xdebug

COPY .docker/app-dev/50_xdebug.ini /etc/php${PHP_VERSION}/conf.d/50_xdebug.ini
COPY .docker/app-dev/extra.ini /etc/php${PHP_VERSION}/conf.d/extra.ini
COPY .docker/app-dev/www.conf /etc/php${PHP_VERSION}/php-fpm.d/www.conf

USER ${USER}

# FPM-PROD
FROM fpm-base as fpm-prod

# NGINX-BASE
FROM nginx:1.23-alpine as nginx-base

ARG UID=1000
ARG GID=1000

RUN apk add --no-cache shadow

RUN usermod --uid $UID nginx
RUN groupmod --non-unique --gid $GID nginx

COPY .docker/nginx-prod/nginx.conf /etc/nginx/nginx.conf

# NGINX-DEV
FROM nginx-base as nginx-dev

COPY .certs /usr/app/.certs
COPY .docker/nginx-dev/nginx.conf /etc/nginx/nginx.conf

# NGINX-PROD
FROM nginx-base as nginx-prod
