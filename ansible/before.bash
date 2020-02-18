#!/bin/bash

mkdir -p .certs
mkcert -install
mkcert -cert-file .certs/certificate.pem -key-file .certs/certificate-key.pem $*
