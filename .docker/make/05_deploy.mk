KAMAL_IMAGE = ghcr.io/basecamp/kamal:v2.4.0
CONFIG_FILE = --config-file .kamal/deploy.yml

KAMAL ?= docker run -it --rm -v "${PWD}:/workdir" -v "/run/host-services/ssh-auth.sock:/run/host-services/ssh-auth.sock" -e SSH_HOST -e SSH_USER -e SSH_PORT -e DOCKER_USERNAME -e DOCKER_PASSWORD -e SSH_AUTH_SOCK="/run/host-services/ssh-auth.sock" -v /var/run/docker.sock:/var/run/docker.sock $(KAMAL_IMAGE)
DESTINATION ?= staging
VERSION ?= latest
ACCESSORY ?= database

KAMAL_FLAGS = $(CONFIG_FILE) --destination=$(DESTINATION)
DEPLOY_FLAGS = --skip-push --version=$(VERSION)

ifneq (,$(wildcard .kamal/.env))
    include .kamal/.env
    export
endif

deploy-setup: ## Initialize the deployment environment.
	$(KAMAL) setup $(KAMAL_FLAGS) $(DEPLOY_FLAGS)
.PHONY: deploy-setup

deploy: ## Deploy the application version to the specified environment.
	$(KAMAL) deploy $(KAMAL_FLAGS) $(DEPLOY_FLAGS)
.PHONY: deploy

deploy-unlock: ## Release the lock on the specified environment.
	$(KAMAL) lock release $(KAMAL_FLAGS)
.PHONY: deploy-unlock

deploy-logs: ## Show the logs of the application in the specified environment.
	$(KAMAL) app logs --follow $(KAMAL_FLAGS)
.PHONY: deploy-logs

deploy-accessory-boot: ## Initialize one or all accessories.
	$(KAMAL) accessory boot $(ACCESSORY) $(KAMAL_FLAGS)
.PHONY: deploy-accessory-boot

deploy-accessory-reboot: ## Stop, remove and boot again one or all accessories.
	$(KAMAL) accessory reboot $(ACCESSORY) $(KAMAL_FLAGS)
.PHONY: deploy-accessory-reboot

deploy-accessory-remove: ## Remove one or all accessories.
	$(KAMAL) accessory remove $(ACCESSORY) $(KAMAL_FLAGS)
.PHONY: deploy-accessory-remove

deploy-accessory-logs: ## Show the logs of one accessory.
	$(KAMAL) accessory logs $(ACCESSORY) $(KAMAL_FLAGS)
.PHONY: deploy-accessory-logs

deploy-remove-all: ## Remove the application from the specified environment.
	$(KAMAL) remove $(KAMAL_FLAGS)
.PHONY: deploy-remove-all

deploy-cmd: ## Execute a custom command on the specified environment.
	$(KAMAL) $(CMD) $(KAMAL_FLAGS)
.PHONY: deploy-cmd
