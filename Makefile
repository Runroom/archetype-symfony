AUTOLOAD = vendor/autoload.php
DOCKER_COMPOSE = docker compose --file .docker/docker-compose.yaml
NODE_MODULES_DIR = node_modules
CERTS_DIR = .docker/nginx/certs
MKCERT = mkcert
UID = $(shell id -u)
GID = $(shell id -g)

DOCKER_EXEC = $(DOCKER_COMPOSE) exec app

# Docker
up: compose $(AUTOLOAD)
.PHONY: up

up-debug:
	XDEBUG_MODE=debug $(MAKE) compose
.PHONY: up-debug

up-prod: build-prod
	DOCKER_ENV=prod APP_ENV=prod APP_DEBUG=0 $(MAKE) compose
.PHONY: up-prod

compose: $(NODE_MODULES_DIR) $(VENDOR_DIR) $(CERTS_DIR)
	$(DOCKER_COMPOSE) up --detach
.PHONY: compose

build: halt
	$(DOCKER_COMPOSE) build --build-arg UID=$(UID) --build-arg GID=$(GID)
.PHONY: build

build-prod:
	DOCKER_ENV=prod $(MAKE) build
.PHONY: build-prod

halt:
	$(DOCKER_COMPOSE) stop
.PHONY: halt

destroy:
	$(DOCKER_COMPOSE) down --remove-orphans --volumes
.PHONY: destroy

ssh:
	$(DOCKER_EXEC) /bin/ash
.PHONY: ssh

$(NODE_MODULES_DIR):
	mkdir -p $(NODE_MODULES_DIR)

$(VENDOR_DIR):
	mkdir -p $(VENDOR_DIR)

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
	$(DOCKER_EXEC) composer install --optimize-autoloader
.PHONY: composer-install

composer-normalize:
	$(DOCKER_EXEC) composer normalize
.PHONY: composer-normalize

phpstan:
	$(DOCKER_EXEC) composer phpstan
.PHONY: phpstan

psalm:
	$(DOCKER_EXEC) composer psalm -- --threads=$(shell nproc)
.PHONY: psalm

rector:
	$(DOCKER_EXEC) composer rector
.PHONY: rector

php-cs-fixer:
	$(DOCKER_EXEC) composer php-cs-fixer
.PHONY: php-cs-fixer

phpunit:
	$(DOCKER_EXEC) phpunit
.PHONY: phpunit

phpunit-coverage:
	$(DOCKER_EXEC) phpunit --coverage-html /usr/app/coverage
.PHONY: phpunit-coverage

# Symfony
cache-clear:
	$(DOCKER_EXEC) rm -rf /usr/app/var/cache/*
.PHONY: cache-clear

assets:
	$(DOCKER_EXEC) console assets:install public
.PHONY: assets

database:
	$(DOCKER_EXEC) console doctrine:database:drop --no-interaction --force
	$(DOCKER_EXEC) console doctrine:database:create --no-interaction
	$(DOCKER_EXEC) console doctrine:migrations:migrate --no-interaction
	$(DOCKER_EXEC) console doctrine:fixtures:load --no-interaction
.PHONY: database
