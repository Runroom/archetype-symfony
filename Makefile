UNAME := $(shell uname)

AUTOLOAD = vendor/autoload.php
CERTS_DIR = .certs
DOCKER_COMPOSE = docker-compose
DOCKER_COMPOSE_FLAGS = -f docker/docker-compose.yaml -f docker/docker-compose-dev.yaml --env-file docker/.env
MKCERT = mkcert

docker-compose = $(DOCKER_COMPOSE) $(DOCKER_COMPOSE_FLAGS) $1
docker-exec =  $(call docker-compose,exec -T app /bin/bash -c "$1")

.PHONY: up composer build halt destroy ssh certs provision composer-install \
		composer-normalize phpstan php-cs-fixer phpunit phpunit-coverage database

# Docker
up: compose $(AUTOLOAD)

compose: $(CERTS_DIR)
ifeq ($(UNAME), Darwin)
	XDEBUG_CONFIG="client_host=host.docker.internal" SSH_AUTH_SOCK=/run/host-services/ssh-auth.sock $(call docker-compose,up -d)
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

grumphp:
	$(call docker-exec,grumphp run)

database:
	$(call docker-exec,console doctrine:database:drop --no-interaction --force)
	$(call docker-exec,console doctrine:database:create --no-interaction)
	# $(call docker-exec,console doctrine:database:import docker/dump.sql)
	$(call docker-exec,console doctrine:migrations:migrate --no-interaction)
