ifndef PROJECT_NAME
$(error PROJECT_NAME must be defined before loading make/02_docker.mk)
endif

ENV ?= dev
UID ?= $(shell id -u)
DOCKER_COMPOSE = docker compose --file .docker/docker-compose.yaml --file .docker/docker-compose.$(ENV).yaml --project-name $(PROJECT_NAME)

up: setup ## Start the containers.
	$(DOCKER_COMPOSE) up --wait
.PHONY: up

up-attach: setup ## Start the containers and attach to the logs.
	$(DOCKER_COMPOSE) up
.PHONY: up-attach

up-debug: setup ## Start the containers in debug mode.
	XDEBUG_MODE=debug $(MAKE) up
.PHONY: up-debug

up-debug-wsl: setup ## Start the containers in debug mode for WSL.
	XDEBUG_HOST=$(shell grep nameserver /etc/resolv.conf | awk '{print $$2}') $(MAKE) up-debug
.PHONY: up-debug-wsl

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

pull: ## Pull the latest images.
	$(DOCKER_COMPOSE) pull
.PHONY: pull

prod: ## Start the containers in production mode.
	ENV=prod $(MAKE) build up
.PHONY: prod

dev: ## Start the containers in development mode. Only used after a `make prod`.
	$(MAKE) build up
.PHONY: dev
