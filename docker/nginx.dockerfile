FROM nginx:stable-alpine

ADD ./docker/conf/nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./docker/conf/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN mkdir -p /var/www/html

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

RUN chown -R laravel:laravel /var/www/html