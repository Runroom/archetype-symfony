ifndef DOCKER_EXEC
$(error DOCKER_EXEC must be defined before loading make/symfony.mk)
endif

provision: composer-install cache-clear assets database ## Install dependencies, clear cache, and provision database.
.PHONY: provision

cache-clear: ## Clear the cache.
	$(DOCKER_EXEC) rm -rf /usr/app/var/cache/*
.PHONY: cache-clear

assets: ## Install assets.
	$(DOCKER_EXEC) console assets:install public
.PHONY: assets

database: ## Provision the database.
	$(DOCKER_EXEC) console doctrine:database:drop --no-interaction --force
	$(DOCKER_EXEC) console doctrine:database:create --no-interaction
	$(DOCKER_EXEC) console doctrine:migrations:migrate --no-interaction
	$(DOCKER_EXEC) console doctrine:fixtures:load --no-interaction
.PHONY: database

check-database: ## Check the database.
# @todo: Remove skip mapping when all entities SonataUserBundle fixes its mapping.
	$(DOCKER_EXEC) console doctrine:schema:validate --skip-mapping
	$(DOCKER_EXEC) console doctrine:migrations:status
.PHONY: check
