#!/usr/bin/env bash

console cache:warmup --no-interaction
console assets:install public
console doctrine:migrations:migrate --no-interaction --allow-no-migration

php-fpm --allow-to-run-as-root
