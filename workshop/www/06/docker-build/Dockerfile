FROM debian:jessie

MAINTAINER Pascal MARTIN <contact@pascal-martin.fr>

RUN apt-get update && apt-get install -y unzip build-essential autoconf bison && apt-get clean

COPY ./files/make-php.sh /tmp/
