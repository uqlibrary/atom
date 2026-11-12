FROM php:8.3-fpm-alpine


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache bash \
    git \
    npm

WORKDIR /atom/src

#ENTRYPOINT ["docker/entrypoint.sh"]

#CMD ["fpm"]
