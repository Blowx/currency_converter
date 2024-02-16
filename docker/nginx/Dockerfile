FROM nginx:alpine

# Use the existing www-data group
RUN adduser -D -H -u 1000 -s /sbin/nologin --no-create-home -G www-data www-data

# Copy configuration files
COPY docker/nginx/nginx.conf /etc/nginx/
#COPY default.conf /etc/nginx/conf.d/
COPY docker/nginx/currency.conf /etc/nginx/conf.d/

ARG PHP_UPSTREAM_CONTAINER=php-score
ARG PHP_UPSTREAM_PORT=9000


EXPOSE 80
