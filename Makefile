AUTOLOAD = vendor/autoload.php
CERTS_DIR = .certs
MKCERT = mkcert
UID = $(shell id -u)
GID = $(shell id -g)

docker-exec = docker compose exec app /bin/bash -c "$1"

.PHONY: up compose build halt destroy ssh certs provision composer-install \
		composer-normalize phpstan psalm php-cs-fixer phpunit phpunit-coverage \
		cache-clear assets database

# Docker
up: compose $(AUTOLOAD)

compose: $(CERTS_DIR)
	docker compose up -d

build: halt
	docker compose build --build-arg UID=$(UID) --build-arg GID=$(GID)

halt:
	docker compose stop

destroy:
	docker compose down --remove-orphans --volumes

ssh:
	docker compose exec app /bin/bash

$(CERTS_DIR):
	$(MAKE) certs

certs:
	mkdir -p $(CERTS_DIR)
	$(MKCERT) -install
	$(MKCERT) -cert-file $(CERTS_DIR)/certificate.pem -key-file $(CERTS_DIR)/certificate-key.pem localhost

# App
$(AUTOLOAD):
	$(MAKE) provision

provision: composer-install cache-clear assets database

composer-install:
	$(call docker-exec,composer install --optimize-autoloader)

composer-normalize:
	$(call docker-exec,composer normalize)

phpstan:
	$(call docker-exec,composer phpstan)

psalm:
	$(call docker-exec,composer psalm -- --threads=$(shell nproc))

php-cs-fixer:
	$(call docker-exec,composer php-cs-fixer)

phpunit:
	$(call docker-exec,phpunit)

phpunit-coverage:
	$(call docker-exec,phpunit --coverage-html /usr/app/coverage)

cache-clear:
	$(call docker-exec,rm -rf /usr/app/var/cache/*)

assets:
	$(call docker-exec,console assets:install public)

database:
	$(call docker-exec,console doctrine:database:drop --no-interaction --force)
	$(call docker-exec,console doctrine:database:create --no-interaction)
	$(call docker-exec,console doctrine:migrations:migrate --no-interaction)
	$(call docker-exec,console doctrine:fixtures:load --no-interaction)
