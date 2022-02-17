FROM php:7.3-apache
LABEL Name=GT Version=0.0.1
RUN apt-get -y update && apt-get install -y git

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

RUN a2enmod rewrite

COPY GT /var/www//html/
EXPOSE 80/tcp
EXPOSE 443/tcp