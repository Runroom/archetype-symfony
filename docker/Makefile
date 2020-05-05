UNAME := $(shell uname)

CERTS_DIR = ../.certs
AUTOLOAD = ../vendor/autoload.php

.PHONY: up certs compose halt destroy build composer-install database provision phpunit phpunit-coverage \
		composer-normalize phpstan php-cs-fixer

# Docker
up: compose $(AUTOLOAD)

$(CERTS_DIR):
	$(MAKE) certs

certs:
	mkdir -p ../.certs
	mkcert -install
	mkcert -cert-file $(CERTS_DIR)/certificate.pem -key-file $(CERTS_DIR)/certificate-key.pem localhost

compose: $(CERTS_DIR)
ifeq ($(UNAME), Darwin)
	SSH_AUTH_SOCK=/run/host-services/ssh-auth.sock docker-compose -f docker-compose.yaml -f docker-compose-dev.yaml up -d
else
	docker-compose -f docker-compose.yaml -f docker-compose-dev.yaml up -d
endif

halt:
	docker-compose stop

destroy:
	docker-compose down --remove-orphans

build: halt
	docker-compose build

# App
$(AUTOLOAD):
	$(MAKE) provision

composer-install:
	./docker-console composer install --optimize-autoloader

database:
	./docker-console console doctrine:database:drop --no-interaction --force
	./docker-console console doctrine:database:create --no-interaction
	# ./docker-console console doctrine:database:import docker/dump.sql
	./docker-console console doctrine:migrations:migrate --no-interaction

provision: composer-install database

phpunit:
	./docker-console phpunit

phpunit-coverage:
	./docker-console phpdbg -qrr vendor/bin/phpunit --coverage-html /srv/app/coverage

composer-normalize:
	./docker-console composer normalize

phpstan:
	./docker-console composer phpstan

php-cs-fixer:
	./docker-console composer php-cs-fixer
