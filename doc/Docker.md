# Docker

## Make Commands

Basic commands that control docker:

- `make certs` generate ssl certificates
- `make up` starts containers
- `make provision` executes needed tasks for the app to work
- `make halt` stops containers
- `make build` rebuilds containers
- `make destroy` removes containers

Basic commands used to control the app

- `make phpunit` executes `phpunit` tests
- `make composer-install` installs `composer` vendors
- `make phpstan-analyse` executes `phpstan`
- `make php-cs-fixer` executes `php-cs-fixer`

## Docker-console

You can run any command from within the docker app container using `docker-console COMMAND` or you can open a shell using `docker-console` without arguments.
