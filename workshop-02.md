# Slot 2 : une interface web pour exécuter du PHP

Objectifs :

 * Exécuter du code PHP dans un container docker
 * Mettre en place une classe *propre*

## Exécuter du code PHP sous docker

Pour exécutr du code PHP sous docker, on a vu les deux possibilités qu'on a :

 * Passer le code en ligne, avec l'option `-r` de `php` ; cf `workshop/www/02/docker-php-01.php`
 * Passer le code sur l'entrée standard, via un *pipe* ; cf `workshop/www/02/docker-php-02.php`

Je pars plutôt sur la seconde approche, qui évite d'avoir trop à jongler avec des échappements.

Pour plus de souplesse dans la manipulation des trois flux `stdin`, `stdout` et `stderr`, tout
en ayant la possibilité de récupérer le status-code en retour de l'exécution de `php`, je passe
par la fonction `proc_open()` de PHP ; cf `workshop/www/02/docker-php-03.php`

Attention à la configuration :

 * Activer les rapports d'erreurs
 * Les erreurs doivent partir vers `stderr` (et pas vers un fichier de log, ni vers `stdout` qui serait alors polluée)


## Une classe qui encapsule tout ça

Le code qu'on vient de voir fonctionne et répond à notre besoin \o/

Encapsulons-le juste dans une classe, qu'on pourra utiliser pour la suite, sans avoir à trop se re-soucier
de ce qu'elle fait *en-dessous*.

Cf `workshop/www/02/docker-php-04.php` et `workshop/www/02/evaluator.php`

