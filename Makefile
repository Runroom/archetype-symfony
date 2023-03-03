ENV ?= dev
NODE_MODULES_DIR = node_modules
CERTS_DIR = .docker/traefik/certs
UID ?= $(shell id -u)
GID ?= $(shell id -g)

DOCKER_COMPOSE = docker compose --file .docker/docker-compose.yaml --file .docker/docker-compose.$(ENV).yaml
DOCKER_EXEC = $(DOCKER_COMPOSE) exec app

# Default
default: $(NODE_MODULES_DIR) $(CERTS_DIR) build up provision
.PHONY: default

# Docker
up:
	$(DOCKER_COMPOSE) up --detach
.PHONY: up

up-attach:
	$(DOCKER_COMPOSE) up
.PHONY: up-attach

up-debug:
	XDEBUG_MODE=debug $(MAKE) up
.PHONY: up-debug

build:
	$(DOCKER_COMPOSE) build --build-arg UID=$(UID) --build-arg GID=$(GID)
.PHONY: build

halt:
	$(DOCKER_COMPOSE) stop
.PHONY: halt

destroy:
	$(DOCKER_COMPOSE) down --remove-orphans --volumes
.PHONY: destroy

ps:
	$(DOCKER_COMPOSE) ps
.PHONY: ps

logs:
	$(DOCKER_COMPOSE) logs --follow
.PHONY: logs

ssh:
	$(DOCKER_EXEC) /bin/ash
.PHONY: ssh

$(NODE_MODULES_DIR):
	mkdir --parents $(NODE_MODULES_DIR)

$(CERTS_DIR):
	$(MAKE) certs

certs:
	mkdir -p $(CERTS_DIR)
	mkcert -install
	mkcert -cert-file $(CERTS_DIR)/cert.crt -key-file $(CERTS_DIR)/cert.key localhost
.PHONY: certs

# Environments
prod:
	ENV=prod $(MAKE) build up
.PHONY: prod

dev:
	$(MAKE) build up
.PHONY: dev

# App
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
