#!/usr/bin/env bash

# Enable job control, so we can kill all child processes when receiving SIGTERM (e.g. on docker stop)
set -m

# Kill background processes on exit
term_handler() {
  if [ $nginxPid -ne 0 ]; then
    kill -SIGTERM "$nginxPid"
    wait "$nginxPid"
  fi

  if [ $phpFpmPid -ne 0 ]; then
    kill -SIGTERM "$phpFpmPid"
    wait "$phpFpmPid"
  fi

  # Exit with sigterm status
  exit 143
}

# Setup signal handlers for graceful shutdowns
trap 'kill ${!}; term_handler' SIGTERM

# Start the first process
php-fpm${PHP_VERSION} &
phpFpmPid=$!

# Start the second process
nginx -g "daemon off;" -e stderr &
nginxPid=$!

# Wait for any process to exit
wait -n

# Exit with status of process that exited first
exit $?
