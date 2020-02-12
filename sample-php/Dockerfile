FROM php:7.0-apache

RUN apt update && apt-get install -y \
        iputils-ping \
        procps && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists* /tmp/* /var/tmp/*

COPY php/ /var/www/html/
