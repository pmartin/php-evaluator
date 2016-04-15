#!/bin/bash

echo "127.0.0.1 ubuntu-xenial" >> /etc/hosts

apt-get update && apt-get dist-upgrade -y

# Utilitaires
apt-get install -y wget procps vim htop curl tree tmux apt-transport-https ca-certificates

# Installation nginx, php7
apt-get install -y nginx-full php7.0-cli php7.0-curl php7.0-dev php7.0-json php7.0-mysql php7.0-opcache php7.0-readline php7.0-xml php7.0-bz2 php7.0-fpm php7.0-intl php7.0-mbstring php7.0-zip php-xdebug

# Suppression du vhost nginx par défaut
rm /etc/nginx/sites-enabled/default
rm -Rf /var/www/html/

# Pour la configuration FPM
useradd --no-create-home --system www-evaluator

# Copie de nos fichiers de conf vers la VM
cp -R /tmp/vagrant-files/* /

# Installation docker, cf https://docs.docker.com/engine/installation/linux/ubuntulinux/
apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D
echo "deb https://apt.dockerproject.org/repo ubuntu-xenial main" > /etc/apt/sources.list.d/docker.list
apt-get update && apt-get install -y linux-image-extra-$(uname -r) docker.io
systemctl enable docker

# Configuration docker
usermod -aG docker ubuntu
usermod -aG docker www-evaluator
sed -i 's/GRUB_CMDLINE_LINUX=""/GRUB_CMDLINE_LINUX="cgroup_enable=memory swapaccount=1"/' /etc/default/grub && update-grub

# Redémarrage des démons, une fois leur configuration déployée
/etc/init.d/nginx restart
/etc/init.d/php7.0-fpm restart
