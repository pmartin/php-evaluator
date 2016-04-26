This file contains WIP notes, that might later be integrated to README.md or to another document.

***

Pour commencer, il faut :

 * Installer VirtualBox
 * Installer Vagrant
 * TODO : voir s'il y a des choses spécifiques à faire (genre sous Windows ? Cf pour php7avance, je crois que j'avais fait quelque chose...)
 * Installer le plugin pour vboxsf : `vagrant plugin install vagrant-vbguest`
 * Lancer la machine : `vagrant up`
 * Vérifier qu'on peut s'y connecter en SSH : `vagrant ssh`
 * Vérifier qu'on ait accès au site : `http://localhost:49080/phpinfo.php`

Pour PHP 7 sous docker :

```bash
docker pull php:7.0-cli
docker run php:7.0-cli php -r 'echo PHP_VERSION, "\n";'
echo '<?php echo PHP_VERSION, "\n"; ?>' | docker run -i php:7.0-cli php
```

La box `ubuntu/xenial64` ne fonctionne pas sous VirtualBox 5.0.18, cf [Ubuntu 16.04 current not booting in Vagrant (gurumeditation)](https://bugs.launchpad.net/cloud-images/+bug/1573058)
=> Utilisation de `gbarbieru/xenial` à la place, au moins temporairement, tant que 5.0.18 est la version stable de VirtualBox...
=> Ou alors, il faut re-descendre à VirtualBox 5.0.16
