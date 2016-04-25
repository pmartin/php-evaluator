# Slot 5 : sécuriser un peu tout ça

Objectifs :

 * Rappeler que *la sécurité* c'est **important**, via quelques exemples d'abus
 * Passer sur quelques directives de configuration de PHP qui peuvent aider
 * Montrer que docker propose également quelques fonctionnalités intéressantes

## La sécurité ?




## Sécurisation : PHP / nginx

Quelques idées :

 * Configurer le nombre de workers nginx / fpm sur la machine hôte
 * `memory_limit`
 * `max_execution_time`
 * N'activer que les extensions que l'on veut réellement : est-ce qu'on veut permettre de tester
   le comportement du **langage** seulement ? Auquel cas, quasiment aucune extension !
 * Désactiver certaines fonctions ou classes :
   [`disable_functions`](http://nl3.php.net/manual/en/ini.core.php#ini.disable-functions)
   et [`disable_classes`](http://nl3.php.net/manual/en/ini.core.php#ini.disable-classes)

Pour ce qui est de PHP, on peut jouer à deux niveaux :

 * Passer des options de configuration en ligne de commande
    * C'est *souple*, on peut modifier à chaque exécution
    * Mais ça fait des commandes *longues*, il faut échapper et tout...
 * Utiliser un fichier de configuration `.ini`
    * Si on le met directement dans le container lors de sa construction, c'est
      compliqué à modifier (il faut re-construire le container) : c'est tout-en-un
      mais moins souple.
    * Sinon : on met ce fichier sur la machine hôte et on le partage avec le container
      par le biais d'un *volume* docker ;-)


## Sécurisation : docker

Même si docker n'est pas *fait pour* apporter de la sécurité au départ, plusieurs fonctionnalités sympathiques
peuvent être utiles pour notre cas. On peut notamment (moyennant un peu de configuration au niveau du système
hôte) limiter la quantité de RAM ou de CPU utilisée par un conteneur.

On peut passer des options à [`docker run`](https://docs.docker.com/engine/reference/run/) :

 * `--net="none"` pour empêcher tout accès réseau
 * `--memory="32m"` pour limiter la quantité de mémoire disponible
 * `--memory-swap="64m"` pour limiter la quantité **totale** de mémoire (RAM+swap) disponible
 * `--memory-swappiness=""` pour tuner le swapiness (0-100)
 * Quand on monte un volume, on peut le monter en lecture seule ;-)


Exemple limitation mémoire :
```
$ docker run -it --rm --memory="32m" --memory-swap="32m" php-jessie php -r '$a = str_repeat("a", 1024*1024*25);'
$ echo $?
0

$ docker run -it --rm --memory="32m" --memory-swap="32m" php-jessie php -r '$a = str_repeat("a", 1024*1024*35);'
$ echo $?
137
```

Penser également aux options suivantes (même si pas tellement de rapport avec la sécurité) :

 * `-it` pour interagir avec le container
 * `--rm` pour effacer le file system du container


Idées lectures complémentaires :

 * [A Look Back at One Year of Docker Security](https://blog.docker.com/2016/04/docker-security/)
 * [Understanding and Hardening Linux Containers](https://www.nccgroup.trust/globalassets/our-research/us/whitepapers/2016/april/ncc_group_understanding_hardening_linux_containers-10pdf/) (pdf)


## Bonus

Bien sûr, on peut aller un peu plus loin et penser à quelques autres idées,

 * Limite sur le nombre de requêtes par seconde / minute par IP (ou autre)

Ou alors, si on pense *scalabilité* :

 * Utiliser une file de job pour exécuter les portions de code
 * Stocker les résultats en DB, pour éviter d'exécuter plusieurs fois une portion de code donnée
   (notamment utile si on persiste les portions de code et permet de les partager)
 * Lancement / extinction de machines *à la volée* pour absorber la charge si beaucoup de gens
   se mettent à utiliser le service
