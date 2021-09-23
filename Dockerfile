# BASE
FROM php:8.0-fpm-buster as base

WORKDIR /usr/app

COPY --from=mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions apcu bz2 gd intl opcache pdo_mysql zip
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    unzip \
    mariadb-client \
    git \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

ENV PATH="/usr/app/vendor/bin:/usr/app/bin:${PATH}"

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY .docker/app-prod/extra.ini /usr/local/etc/php/conf.d/extra.ini
COPY .docker/app-prod/www.conf /usr/local/etc/php-fpm.d/www.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# NODE-PROD
FROM node:14-buster as node-prod

WORKDIR /usr/app

COPY .yarn /usr/app/.yarn
COPY .yarnrc.yml /usr/app/yarnrc.yml
COPY package.json /usr/app/package.json
COPY yarn.lock /usr/app/yarn.lock

RUN yarn install --immutable

COPY webpack.config.js /usr/app/webpack.config.js
COPY .babelrc /usr/app/.babelrc
COPY .browserslistrc /usr/app/.browserslistrc
COPY .eslintrc /usr/app/.eslintrc
COPY .stylelintrc /usr/app/.stylelintrc
COPY postcss.config.js /usr/app/postcss.config.js

COPY assets /usr/app/assets

RUN yarn encore production

# FPM-PROD
FROM base as fpm-prod

COPY .env /usr/app/.env

COPY composer.json /usr/app/composer.json
COPY composer.lock /usr/app/composer.lock
COPY symfony.lock /usr/app/symfony.lock

RUN composer install --prefer-dist --no-progress --no-interaction --no-dev

COPY . /usr/app

RUN composer dump-autoload --classmap-authoritative
RUN composer symfony:dump-env prod

COPY --from=node-prod /usr/app/public/build /usr/app/public/build

ENTRYPOINT ["bash", "/usr/app/.docker/app-prod/php-fpm.sh"]

# FPM-DEV
FROM base as fpm-dev

RUN install-php-extensions pcov xdebug

CMD ["php-fpm", "--allow-to-run-as-root"]
