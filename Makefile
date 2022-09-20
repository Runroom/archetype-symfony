AUTOLOAD = vendor/autoload.php
NODE_MODULES_DIR = node_modules
CERTS_DIR = .certs
MKCERT = mkcert
UID = $(shell id -u)
GID = $(shell id -g)

docker-exec = docker compose exec app /bin/bash -c "$1"

# Docker
up: compose $(AUTOLOAD)
.PHONY: up

up-debug:
	XDEBUG_MODE=debug docker compose up -d
.PHONY: up-debug

compose: $(NODE_MODULES_DIR) $(CERTS_DIR)
	docker compose up -d
.PHONY: compose

build: halt
	docker compose build --build-arg UID=$(UID) --build-arg GID=$(GID)
.PHONY: build

halt:
	docker compose stop
.PHONY: halt

destroy:
	docker compose down --remove-orphans --volumes
.PHONY: destroy

ssh:
	docker compose exec app /bin/bash
.PHONY: ssh

$(NODE_MODULES_DIR):
	mkdir -p $(NODE_MODULES_DIR)

$(CERTS_DIR):
	$(MAKE) certs

certs:
	mkdir -p $(CERTS_DIR)
	$(MKCERT) -install
	$(MKCERT) -cert-file $(CERTS_DIR)/certificate.pem -key-file $(CERTS_DIR)/certificate-key.pem localhost
.PHONY: certs

# App
$(AUTOLOAD):
	$(MAKE) provision

provision: composer-install cache-clear assets database
.PHONY: provision

composer-install:
	$(call docker-exec,composer install --optimize-autoloader)
.PHONY: composer-install

composer-normalize:
	$(call docker-exec,composer normalize)
.PHONY: composer-normalize

phpstan:
	$(call docker-exec,composer phpstan)
.PHONY: phpstan

psalm:
	$(call docker-exec,composer psalm -- --threads=$(shell nproc))
.PHONY: psalm

rector:
	$(call docker-exec,composer rector)
.PHONY: rector

php-cs-fixer:
	$(call docker-exec,composer php-cs-fixer)
.PHONY: php-cs-fixer

phpunit:
	$(call docker-exec,phpunit)
.PHONY: phpunit

phpunit-coverage:
	$(call docker-exec,phpunit --coverage-html /usr/app/coverage)
.PHONY: phpunit-coverage

# Symfony
cache-clear:
	$(call docker-exec,rm -rf /usr/app/var/cache/*)
.PHONY: cache-clear

assets:
	$(call docker-exec,console assets:install public)
.PHONY: assets

database:
	$(call docker-exec,console doctrine:database:drop --no-interaction --force)
	$(call docker-exec,console doctrine:database:create --no-interaction)
	$(call docker-exec,console doctrine:migrations:migrate --no-interaction)
	$(call docker-exec,console doctrine:fixtures:load --no-interaction)
.PHONY: database
