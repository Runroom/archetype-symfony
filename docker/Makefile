DOCKER_SYNC := $(shell which docker-sync 2> /dev/null)

# Docker
certs:
	mkdir -p ../.certs
	mkcert -install
	mkcert -cert-file ../.certs/certificate.pem -key-file ../.certs/certificate-key.pem localhost

up: certs
ifdef DOCKER_SYNC
	docker-sync start -c docker-sync.yaml --no-logd
	docker-compose -f docker-compose.yaml -f docker-compose-sync.yaml up -d
else
	docker-compose -f docker-compose.yaml -f docker-compose-default.yaml up -d
endif

halt:
	docker-compose stop
ifdef DOCKER_SYNC
	docker-sync stop -c docker-sync.yaml
endif

destroy: halt
	docker container prune -f
	docker image prune -af
	docker volume prune -f
ifdef DOCKER_SYNC
	docker-sync clean -c docker-sync.yaml
endif

build: halt
	docker-compose build

# App
composer-install:
	./docker-console composer install --optimize-autoloader

database:
	./docker-console console doctrine:database:drop --no-interaction --force
	./docker-console console doctrine:database:create --no-interaction
	# ./docker-console console doctrine:database:import docker/dump.sql
	./docker-console console doctrine:migrations:migrate --no-interaction

provision: composer-install database

phpunit:
	./docker-console phpunit

phpunit-coverage:
	./docker-console phpdbg -qrr vendor/bin/phpunit --coverage-html /srv/app/coverage

composer-normalize:
	./docker-console composer normalize

phpstan:
	./docker-console composer phpstan

php-cs-fixer:
	./docker-console php-cs-fixer fix
