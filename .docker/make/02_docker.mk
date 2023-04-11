ENV ?= dev
UID ?= $(shell id -u)

DOCKER_COMPOSE = docker compose --file .docker/docker-compose.yaml --file .docker/docker-compose.$(ENV).yaml

up: ## Start the containers.
	$(DOCKER_COMPOSE) up --wait
.PHONY: up

up-attach: ## Start the containers and attach to the logs.
	$(DOCKER_COMPOSE) up
.PHONY: up-attach

up-debug: ## Start the containers in debug mode.
	XDEBUG_MODE=debug $(MAKE) up
.PHONY: up-debug

build: ## Build the containers.
	$(DOCKER_COMPOSE) build --build-arg UID=$(UID)
.PHONY: build

halt: ## Stop the containers.
	$(DOCKER_COMPOSE) stop
.PHONY: halt

destroy: ## Stop and remove the containers.
	$(DOCKER_COMPOSE) down --remove-orphans --volumes
.PHONY: destroy

ps: ## List the containers.
	$(DOCKER_COMPOSE) ps
.PHONY: ps

logs: ## Follow the logs.
	$(DOCKER_COMPOSE) logs --follow
.PHONY: logs

prod: ## Start the containers in production mode.
	ENV=prod $(MAKE) build up
.PHONY: prod

dev: ## Start the containers in development mode. Only used after a `make prod`.
	$(MAKE) build up
.PHONY: dev
