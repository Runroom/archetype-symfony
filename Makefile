UNAME := $(shell uname)

AUTOLOAD = vendor/autoload.php
CERTS_DIR = .certs
DOCKER_COMPOSE = docker-compose
DOCKER_COMPOSE_FLAGS = -f docker/docker-compose.yaml -f docker/docker-compose-dev.yaml --env-file docker/.env
MKCERT = mkcert

docker-compose = $(DOCKER_COMPOSE) $(DOCKER_COMPOSE_FLAGS) $1
docker-exec =  $(call docker-compose,exec -T app /bin/bash -c "$1")

.PHONY: up certs compose halt destroy build composer-install database provision phpunit phpunit-coverage \
		composer-normalize phpstan php-cs-fixer

# Docker
up: compose $(AUTOLOAD)

compose: $(CERTS_DIR)
ifeq ($(UNAME), Darwin)
	SSH_AUTH_SOCK=/run/host-services/ssh-auth.sock $(call docker-compose,up -d)
else
	$(call docker-compose,up -d)
endif

build: halt
	$(call docker-compose,build)

halt:
	$(call docker-compose,stop)

destroy:
	$(call docker-compose,down --remove-orphans)

ssh:
	$(call docker-compose,exec app /bin/bash)

$(CERTS_DIR):
	$(MAKE) certs

certs:
	mkdir -p $(CERTS_DIR)
	$(MKCERT) -install
	$(MKCERT) -cert-file $(CERTS_DIR)/certificate.pem -key-file $(CERTS_DIR)/certificate-key.pem localhost

# App
$(AUTOLOAD):
	$(MAKE) provision

provision: composer-install database

composer-install:
	$(call docker-exec,composer install --optimize-autoloader)

composer-normalize:
	$(call docker-exec,composer normalize)

phpstan:
	$(call docker-exec,composer phpstan)

php-cs-fixer:
	$(call docker-exec,composer php-cs-fixer)

phpunit:
	$(call docker-exec,phpunit)

phpunit-coverage:
	$(call docker-exec,phpdbg -qrr vendor/bin/phpunit --coverage-html /srv/app/coverage)

database:
	$(call docker-exec,console doctrine:database:drop --no-interaction --force)
	$(call docker-exec,console doctrine:database:create --no-interaction)
	# $(call docker-exec,console doctrine:database:import docker/dump.sql)
	$(call docker-exec,console doctrine:migrations:migrate --no-interaction)
