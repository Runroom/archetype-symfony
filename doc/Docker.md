# Docker

## Make Commands

Basic commands that control docker:

- `make certs` generate ssl certificates
- `make up` starts containers
- `make provision` executes needed tasks for the app to work
- `make ssh` starts a shell in the app container
- `make halt` stops containers
- `make build` rebuilds containers
- `make destroy` removes containers

Basic commands used to control the app

- `make composer-install` installs `composer` vendors
- `make database` creates the database using ansible/drupal.sql
- `make phpunit` executes `phpunit` tests
- `make composer-normalize` executes `composer normalize` plugin to normalize composer.json
- `make phpstan` executes `phpstan`
- `make php-cs-fixer` executes `php-cs-fixer`
