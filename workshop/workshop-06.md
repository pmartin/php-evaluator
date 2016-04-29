# Slot 6 : construire une version personnalisée de PHP

Objectifs :

 * Construire **la** version de PHP qui nous intéresse
 * Utiliser un docker pour le build et un autre pour l'exécution
 * Ajouter l'image docker de *notre* version de PHP à la liste de celles utilisées

## Mais pourquoi ? Quelle version de PHP ?

Utiliser une version de PHP packagée par une distribution ou un packageur connu, plusieurs avantages :

 * On permet de tester sour une version de PHP largement utilisée ; celle qu'on a des chances d'avoir en production
 * On a une version bien packagée, avec configuration *de production*
 * On n'a pas à s'embêter pour l'installation : `apt-get install ...` *et voila*

Mais :

 * On est limité, niveau choix de version :

    * Soit la dernière version stable de chaque version mineure (et encore)
    * Soit une version *au hasard* en gros

 * On peut avoir à *subir* les choix du packageur

    * Extensions pré-intégrées, par exemple

Constuire notre propre version de PHP a plusieurs avantages :

 * On dispose exactement de **la** version qu'on veut ; genre *toutes* les versions mineures, par exemple
 * On peut remonter aussi loin qu'on veut dans le temps, pour peu qu'on trouve une version de distribution
   qui fournisse les dépendances *système*
 * On compile avec toutes les options qu'on veut


## Un docker pour builder PHP

On va construire un container docker qui nous permettra de construire PHP depuis la branche `master` -- et donc, d'avoir
ce qui, petit à petit, est en train de devenir PHP 7.1.

Note : on pourrait choisir de constuire n'importe quelle autre version, mais je prends celle-ci pour plusieurs raisons :

 * C'est plus *fun* que de prendre une vieille version ; même s'il y a un risque que *ça ne marche pas*
 * Github fournit un snapshot de `master`, ça évite de cloner l'intégralité du (gros) repo ;-)

Pour le snapshot : [github.com/php/php-src](https://github.com/php/php-src) ; le télécharger en local, quelque part
dans le projet (pour qu'il soit partagé avec la VM).

Dans de docker, on a besoin des dépendances requises par PHP pour sa compilation.

```bash
cd /var/www/06/docker-build
docker build --rm --tag=php-7.1-builder .
```

Et pour construire PHP :

```bash
docker run -it --rm \
    --volume=/var/www/php-src-master.zip:/tmp/php-src-master.zip:ro \
    --volume=/var/www/php-build/php-7.1-dev/:/usr/local/php-7.1-dev/:rw \
    php-7.1-builder bash /tmp/make-php.sh
```

On pourrait aussi, surtout pour tester lorsqu'on met en place le script, lancer `bash` et taper nous-même les
commandes que celui-ci contient ;-)

Une fois ceci fait, on obtient dans `/var/www/php-build/php-7.1-dev/` dans la VM (par le biais du volume) tout ce qui
correspond à PHP 7.1 -- qu'on va maintenant pouvoir songer à exécuter !


## Un docker pour exécuter PHP

On essaye de travailler avec des images les plus légères possibles, n'embarquant pas 36 logiciels ou 42k bibliothèques
"pour rien" (bon, partir d'une debian stable, c'était déjà un peu lourd... mais je nous ai simplifié la vie en prenant
une distrib connue).

Nous n'utilisons donc pas notre image docker de *construction* de PHP pour l'exécution.

Nous allons mettre en place une autre image, dédiée à l'*exécution* de PHP. Elle n'intégre que le nécessaire : les
paquets de base, peut-être quelques bibliothèques système (pas en version `-dev` !) requises par des extensions, mais
pas les paquets de développement employés pour construire PHP.

```bash
cd /var/www/06/docker-run
docker build --rm --tag=php-7.1 .
```

Une fois cette image construire, on peut l'utiliser pour exécuter du code PHP :

```bash
docker run -it --rm \
    --volume /var/www/php-build/php-7.1-dev/:/usr/local/php-7.1-dev/:ro \
    --env PATH=/usr/local/php-7.1-dev/bin/:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin \
    php-7.1 php --version
```

A noter :

 * On utilise notre image d'*exécution* : `php-7.1`
 * On partage tout ce qu'on a *construit* précédemment, via un volume **en lecture seule**
 * On définit la variable d'environnement `$PATH` pour ne pas avoir à spécifier le chemin absolu vers `php`


## Branchement dans l'application

On reprend ce qu'on avait mis en place il y a quelques temps (par exemple au slot-04) et on ajoute une image à la liste
des images déjà définies.

Un point d'attention : on doit désormais passer des options supplémentaires à `docker run` (le volume, la surcharge de
`PATH`)... Il nous faut donc retoucher un peu le code de notre classe d'évalution ;-)
