MAKEFILE_PATH := $(abspath $(lastword $(MAKEFILE_LIST)))
PROJECT_NAME := $(shell echo $(notdir $(patsubst %/,%,$(dir $(MAKEFILE_PATH)))) | tr '[:upper:]' '[:lower:]')

include .docker/Makefile
