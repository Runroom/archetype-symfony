FROM nginx:1.23-alpine as nginx-prod

ARG UID=1000
ARG GID=1000

RUN apk add --no-cache shadow

RUN usermod --uid $UID nginx
RUN groupmod --non-unique --gid $GID nginx

COPY prod/nginx.conf /etc/nginx/nginx.conf

FROM nginx-prod as nginx-dev

COPY certs /etc/nginx/certs
COPY dev/nginx.conf /etc/nginx/nginx.conf
