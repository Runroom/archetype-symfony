NODE_MODULES_DIR = node_modules
CERTS_DIR = .docker/traefik/certs

setup: ## Initial setup to get the project running.
	mkdir --parents $(NODE_MODULES_DIR)
	mkdir --parents $(CERTS_DIR)
	mkcert -install
	mkcert -cert-file $(CERTS_DIR)/cert.crt -key-file $(CERTS_DIR)/cert.key localhost
.PHONY: setup
