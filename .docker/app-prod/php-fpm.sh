#!/usr/bin/env bash

# Can be used on staging environments to destroy the database each time you deploy
# the application, to ensure you start with the initial data each time
if [ "${RESET_DATABASE:-}" = true ]; then
    echo 'Resetting database...'

    console doctrine:database:drop --no-interaction --force
    console doctrine:database:create --no-interaction
    console doctrine:schema:update --no-interaction --force
    APP_ENV=staging console doctrine:fixtures:load --no-interaction --append

    # If your infrastructure allows to run sidecar containers or jobs, you might want to exit here.
    # exit 0
fi

# Can be used on production environments to apply migrations to the database each time
# you deploy the application, to ensure you start with the database in a correct state
if [ "${MIGRATE_DATABASE:-}" = true ]; then
    echo 'Applying migrations to database...'

    console doctrine:migrations:migrate --no-interaction --allow-no-migration

    # If your infrastructure allows to run sidecar containers or jobs, you might want to exit here.
    # exit 0
fi

# Can be used on production environments to run Symfony Messenger workers
# to consume queued messages. For example: emails or long processing tasks
if [ "${CONSUME_MESSAGES:-}" = true ]; then
    echo 'Consume messages...'

    console messenger:consume async --time-limit=3600 -vv >&1

    exit 0
fi

php-fpm
