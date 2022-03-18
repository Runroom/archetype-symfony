# FPM-BASE
FROM php:8.1-fpm as fpm-base

ARG UID=1000
ARG GID=1000

RUN usermod -u $UID www-data
RUN groupmod -g $GID www-data

COPY --from=mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions apcu bz2 gd intl opcache pcntl pdo_pgsql zip
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    unzip \
    postgresql-client \
    git \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

ENV PATH="/usr/app/vendor/bin:/usr/app/bin:${PATH}"

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY .docker/app-prod/healthcheck.sh /usr/local/bin/healthcheck
COPY .docker/app-prod/extra.ini /usr/local/etc/php/conf.d/extra.ini
COPY .docker/app-prod/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN chmod +x /usr/local/bin/healthcheck

COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer

RUN chown $UID:$GID /var/www

USER www-data

WORKDIR /usr/app

# NODE-PROD
FROM node:17.7 as node-prod

ARG UID=1000
ARG GID=1000

RUN usermod -u $UID node
RUN groupmod -g $GID node

USER node

WORKDIR /usr/app

COPY --chown=$UID:$GID package.json /usr/app/package.json
COPY --chown=$UID:$GID package-lock.json /usr/app/package-lock.json

RUN npm clean-install

COPY --chown=$UID:$GID webpack.config.js /usr/app/webpack.config.js
COPY --chown=$UID:$GID babel.config.js /usr/app/babel.config.js
COPY --chown=$UID:$GID .browserslistrc /usr/app/.browserslistrc
COPY --chown=$UID:$GID .eslintrc.js /usr/app/.eslintrc.js
COPY --chown=$UID:$GID stylelint.config.js /usr/app/stylelint.config.js
COPY --chown=$UID:$GID postcss.config.js /usr/app/postcss.config.js
COPY --chown=$UID:$GID prettier.config.js /usr/app/prettier.config.js
COPY --chown=$UID:$GID etc/tailwind /usr/app/etc/tailwind
COPY --chown=$UID:$GID tsconfig.json /usr/app/tsconfig.json

COPY --chown=$UID:$GID templates /usr/app/templates
COPY --chown=$UID:$GID assets /usr/app/assets

RUN npx encore production

# FPM-PROD
FROM fpm-base as fpm-prod

COPY .env /usr/app/.env

COPY --chown=$UID:$GID composer.json /usr/app/composer.json
COPY --chown=$UID:$GID composer.lock /usr/app/composer.lock
COPY --chown=$UID:$GID symfony.lock /usr/app/symfony.lock

RUN composer install --prefer-dist --no-progress --no-interaction --no-dev

COPY --chown=$UID:$GID . /usr/app

RUN composer dump-autoload --classmap-authoritative
RUN composer symfony:dump-env prod

RUN console cache:warmup
RUN console assets:install public

COPY --chown=$UID:$GID --from=node-prod /usr/app/public/build /usr/app/public/build

ENTRYPOINT ["bash", "/usr/app/.docker/app-prod/php-fpm.sh"]

# FPM-DEV
FROM fpm-base as fpm-dev

USER root

RUN install-php-extensions pcov xdebug

USER www-data

# NGINX-DEV
FROM nginx:1.21 as nginx-base

ARG UID=1000
ARG GID=1000

RUN usermod -u $UID nginx
RUN groupmod -g $GID nginx

# NGINX-PROD
FROM nginx-base as nginx-prod

COPY --chown=$UID:$GID --from=fpm-prod /usr/app/public /usr/app/public
COPY .docker/nginx-prod/nginx.conf /etc/nginx/nginx.conf
