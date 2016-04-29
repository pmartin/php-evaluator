# Slot 7 : exécution du code en asynchrone

Objectifs :

 * Utiliser React-PHP pour exécuter les `docker run` en asynchrone
 * Exécuter le code sous plusieurs versions de PHP *en même temps*
 * Réduire le temps d'attente de l'utilisateur ; sans partir sur la mise en place d'une file de jobs

## Un exemple qui montrera pourquoi

Lançons une portion de code PHP sur deux images docker :
```bash
time php exemple-no-async.php
```

On voit que le code est exécuté sur une image, **puis** sur l'autre. La durée totale (en gros) est deux fois
la durée d'exécution du script.

C'est un peu dommage :

 * Si on a plusieurs CPU sur la machine, on pourrait envisager de paralléliser
 * Si le script passe beaucoup de temps à *attendre* (des I/O par exemple), on pourrait faire *autre chose* en attendant

Sans aller jusqu'à du multi-thread et de la vraie parallélisation, essayons de l'asynchrone.


## Quelques mots sur ReactPHP

[reactphp.org](http://reactphp.org/) : Event-driven, non-blocking I/O with PHP

Le composant qui nous intéresse : [`reactphp/child-process`](https://github.com/reactphp/child-process)


## Installation des composants

On commence par récupérer `composer.phar` depuis [getcomposer.org](https://getcomposer.org/download/), puis on requiert
le composant qui sera utilisé :

```bash
cd /var/www/07
php composer.phar require react/child-process
```

## Un premier exemple d'exécution de processus en asynchrone

Avant d'exécuter du code PHP dans des dockers en asynchrone et tout, commençons par un exemple plus simple : nous
allons exécuter une simple commande Linux, en asynchrone.

Cf `workshop/www/07/exemple-async-01.php`


## Adapter notre exemple : exécution asynchrone

Passons à l'exécution, avec de l'asynchrone, toujours en exécutant une portion de code PHP sur deux images :
```bash
time php exemple-async-02.php
```

Globalement, sur cet exemple, on divise la durée d'exécution par deux ;-). Bon, c'est un exemple où le code PHP
ne fait globalement rien d'autre *qu'attendre* sans consommer de CPU et on est sur une VM avec deux CPU, donc ça
tombe *plutôt bien*.


## Intégration du principe à notre application

Il ne reste *plus qu'à* intégrer ça à notre application ;-)

Cf `workshop/www/07/eval.php`

Le fonctionnement, pour un utilisateur, reste identique : il doit attendre que le code soit exécuté avant que la
réponse à sa requête ne revienne (ce n'est donc pas "en arrière-plan"). Mais les résultats arrivent plus rapidement
(toujours "le même temps", qu'on ait 1 ou 5 images -- pour peu que ça ne soit pas le CPU qui limite, bien sûr).

On peut comparer avec ce qu'on avait sur le slot-04 : le résultat obtenu est le même... mais pas le temps mis pour
l'obtenir ;-)
