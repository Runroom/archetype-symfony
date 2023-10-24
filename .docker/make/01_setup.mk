CERTS_DIR = .docker/traefik/certs
NODE_MODULES_DIR = node_modules
MANIFEST_FILE = public/build/manifest.json
MKCERT := $(shell command -v mkcert 2> /dev/null)

# MacOS does not support --parents for the mkdir command

setup: ${CERTS_DIR} ${NODE_MODULES_DIR} ${MANIFEST_FILE} ## Create the directories and files needed for local development.
.PHONY: setup

certs: ## Create a self-signed certificate for local development.
	mkdir -p ${CERTS_DIR}

ifndef MKCERT
	$(info No mkcert was found in PATH, install it from here: https://github.com/FiloSottile/mkcert)
else
	mkcert -install
	mkcert -cert-file $(CERTS_DIR)/cert.crt -key-file $(CERTS_DIR)/cert.key localhost
endif
.PHONY: certs

${CERTS_DIR}:
	$(MAKE) certs

${NODE_MODULES_DIR}:
	mkdir -p ${NODE_MODULES_DIR}

${MANIFEST_FILE}:
	echo '{}' > $(MANIFEST_FILE)
