default: setup build up provision ## Initial setup to get the project running. Can also be run with `make`.
.PHONY: default

help: ## Show this help.
	@grep -Fh "##"  $(MAKEFILE_LIST) | grep -Fv grep -F | sed -e 's/\\$$//' | sed -e 's/:.* ##/: ##/' | sed -e 's/## \?//' | sed -e ''/^/s//`printf "\033[32m"`/'' | sed -e ''/:/s//`printf ":\033[00m"`/''

include .docker/make/*.mk
