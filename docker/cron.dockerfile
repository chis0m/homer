FROM php:8.0-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

COPY ./docker/conf/clcron /etc/crontabs/root

CMD ["crond", "-f"]
