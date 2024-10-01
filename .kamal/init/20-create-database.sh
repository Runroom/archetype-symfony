#!/bin/bash
set -e

POSTGRES="psql --username ${POSTGRES_USER}"

echo "Creating database: ${STAGING_DB}"

$POSTGRES <<-EOSQL
CREATE DATABASE ${STAGING_DB} OWNER ${STAGING_USER};
EOSQL
