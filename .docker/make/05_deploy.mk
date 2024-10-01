KAMAL_IMAGE = ghcr.io/basecamp/kamal:v1.9.1
CONFIG_FILE = --config-file .kamal/deploy.yml

KAMAL ?= docker run -it --rm -v "${PWD}:/workdir" -v "/run/host-services/ssh-auth.sock:/run/host-services/ssh-auth.sock" -e SSH_AUTH_SOCK="/run/host-services/ssh-auth.sock" -v /var/run/docker.sock:/var/run/docker.sock $(KAMAL_IMAGE)
DESTINATION ?= staging
VERSION ?= latest
ACCESSORY ?= all

KAMAL_FLAGS = $(CONFIG_FILE) --destination=$(DESTINATION)
DEPLOY_FLAGS = --skip-push --version=$(VERSION)

deploy-setup: ## Initialize the deployment environment.
	$(KAMAL) setup $(KAMAL_FLAGS) $(DEPLOY_FLAGS)
.PHONY: deploy-setup

deploy: ## Deploy the application version to the specified environment.
	$(KAMAL) deploy $(KAMAL_FLAGS) $(DEPLOY_FLAGS)
.PHONY: deploy

deploy-env-push: ## Push the environment variables to the specified environment.
	$(KAMAL) env push $(KAMAL_FLAGS)
.PHONY: deploy-env-push

deploy-app-logs: ## Show the logs of the application in the specified environment.
	$(KAMAL) app logs --follow $(KAMAL_FLAGS)
.PHONY: deploy-app-logs

deploy-accessory-boot: ## Initialize one or all accessories.
	$(KAMAL) accessory boot $(ACCESSORY) $(KAMAL_FLAGS)
.PHONY: deploy-accessory-boot

deploy-lock-release: ## Release the lock on the specified environment.
	$(KAMAL) lock release $(KAMAL_FLAGS)
.PHONY: deploy-unlock

deploy-remove-all: ## Remove the application from the specified environment.
	$(KAMAL) remove $(KAMAL_FLAGS)
.PHONY: deploy-remove-all

deploy-accessory-remove: ## Remove one or all accessories.
	$(KAMAL) accessory remove $(ACCESSORY) $(KAMAL_FLAGS)
.PHONY: deploy-accessory-remove

deploy-custom-command: ## Execute a custom command on the specified environment.
	$(KAMAL) $(CMD) $(KAMAL_FLAGS)
.PHONY: deploy-custom-command
