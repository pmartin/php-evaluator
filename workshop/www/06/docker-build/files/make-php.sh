#!/bin/sh

cd /tmp/
unzip php-src-master.zip

cd /tmp/php-src-master/
./buildconf
./configure --disable-all --prefix=/usr/local/php-7.1-dev
make -j 2 -l 4
make install

/usr/local/php-7.1-dev/bin/php --version
/usr/local/php-7.1-dev/bin/php -m
