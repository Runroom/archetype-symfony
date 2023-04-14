NODE_MODULES_DIR = node_modules
CERTS_DIR = .docker/traefik/certs
BUILD_DIR = public/build

setup: ## Create the directories and files needed for local development.
	mkdir --parents $(NODE_MODULES_DIR)
	[ -f $(BUILD_DIR)/manifest.json ] || echo '{}' > $(BUILD_DIR)/manifest.json
.PHONY: setup

certs: ## Create a self-signed certificate for local development.
	mkcert -install
	mkdir --parents $(CERTS_DIR)
	mkcert -cert-file $(CERTS_DIR)/cert.crt -key-file $(CERTS_DIR)/cert.key localhost
.PHONY: certs
