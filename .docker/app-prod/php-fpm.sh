#!/usr/bin/env bash

# Wait for mysql to be ready (avoid if have another way to check for readyness)
sleep 10s

console cache:warmup --no-interaction
console assets:install public
console doctrine:migrations:migrate --no-interaction --allow-no-migration

php-fpm --allow-to-run-as-root
