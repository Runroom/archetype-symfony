#!/bin/bash

mkdir -p .certs

cd $_

mkcert -install
mkcert -cert-file certificate.pem -key-file certificate-key.pem $*
