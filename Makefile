MAKEFILE_PATH := $(abspath $(lastword $(MAKEFILE_LIST)))
ROOT_DIR := $(dir $(MAKEFILE_PATH))
PROJECT_NAME := $(notdir $(patsubst %/,%,$(dir $(MAKEFILE_PATH))))

include vendor/runroom/infrastructure/.docker/Makefile

vendor/runroom/infrastructure/.docker/Makefile:
	mv composer.json composer.json~ && mv composer.lock composer.lock~
	docker run --rm --user '$(shell id -u):$(shell id -g)' --volume '$(shell pwd):/app' --workdir /app composer:2 require runroom/infrastructure:"@dev"
	mv composer.json~ composer.json && mv composer.lock~ composer.lock
