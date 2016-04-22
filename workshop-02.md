# Slot 2 : une interface web pour exécuter du PHP

Objectifs :

 * Exécuter du code PHP dans un container docker
 * Mettre en place une classe *propre*

## Exécuter du code PHP sous docker

Pour exécutr du code PHP sous docker, on a vu les deux possibilités qu'on a :

 * Passer le code en ligne, avec l'option `-r` de `php`
 * Passer le code sur l'entrée standard, via un *pipe*

Je pars plutôt sur la seconde approche, qui évite d'avoir trop à jongler avec des échappements.

Pour plus de souplesse dans la manipulation des trois flux `stdin`, `stdout` et `stderr`, tout
en ayant la possibilité de récupérer le status-code en retour de l'exécution de `php`, je passe
par la fonction `proc_open()` de PHP.

Attention à la configuration :

 * Activer les rapports d'erreurs
 * Les erreurs doivent partir vers `stderr` (et pas vers un fichier de log, ni vers `stdout` qui serait alors polluée)


## Une classe qui encapsule tout ça


