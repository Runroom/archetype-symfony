ifndef DOCKER_COMPOSE
$(error DOCKER_COMPOSE must be defined before loading make/03_app.mk)
endif

DOCKER_EXEC = $(DOCKER_COMPOSE) exec app

ssh: ## SSH into the app container.
	$(DOCKER_EXEC) /bin/ash
.PHONY: ssh

composer-install: ## Install dependencies.
	$(DOCKER_EXEC) composer install --optimize-autoloader
.PHONY: composer-install

composer-normalize: ## Normalize composer.json.
	$(DOCKER_EXEC) composer normalize
.PHONY: composer-normalize

phpstan: ## Run PHPStan.
	$(DOCKER_EXEC) composer phpstan
.PHONY: phpstan

psalm: ## Run Psalm.
	$(DOCKER_EXEC) composer psalm -- --threads=$(shell nproc)
.PHONY: psalm

rector: ## Run Rector.
	$(DOCKER_EXEC) composer rector
.PHONY: rector

php-cs-fixer: ## Run PHP-CS-Fixer.
	$(DOCKER_EXEC) composer php-cs-fixer
.PHONY: php-cs-fixer

phpunit: ## Run PHPUnit.
	$(DOCKER_EXEC) phpunit
.PHONY: phpunit

phpunit-coverage: ## Run PHPUnit with coverage.
	$(DOCKER_EXEC) phpunit --coverage-html /usr/app/coverage
.PHONY: phpunit-coverage

