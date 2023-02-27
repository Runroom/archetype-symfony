# NGINX-BASE
FROM nginx:1.23-alpine as nginx-base

ARG UID=1000
ARG GID=1000

RUN apk add --no-cache shadow

RUN usermod --uid $UID nginx
RUN groupmod --non-unique --gid $GID nginx

COPY prod/nginx.conf /etc/nginx/nginx.conf

# NGINX-DEV
FROM nginx-base as nginx-dev

COPY certs /etc/nginx/certs
COPY dev/nginx.conf /etc/nginx/nginx.conf

# NGINX-PROD
FROM nginx-base as nginx-prod
