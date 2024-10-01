#!/bin/bash
set -e

POSTGRES="psql --username ${POSTGRES_USER}"

echo "Creating database role: ${STAGING_USER}"

$POSTGRES <<-EOSQL
CREATE USER ${STAGING_USER} WITH CREATEDB PASSWORD '${STAGING_PASSWORD}';
EOSQL
