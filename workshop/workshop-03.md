# Slot 3 : une interface web

Objectifs :

 * Mettre en place une web HTML avec un formulaire permettant de saisir du code PHP
 * Celui-ci POSTe vers un script PHP
 * Ce script PHP exécute le code PHP reçu depuis le formulaire
 * Dans un container docker ;-)


## Un formulaire HTML

On commence nos branchements par un formulaire HTML *tout bête*, avec un champ `<textarea>`
pour saisir la portion de code PHP et un bouton pour envoyer le formulaire.

Cf `workshop/www/03/index.php`


## Un script PHP

Ce formulaire POSTe vers un script PHP, qui fait appel à la classe vue précédemment pour exécuter le code.

Les informations suivantes sont récupérées et affichées :

 * Status code
 * Sortie standard
 * Sortie d'erreurs

Cf `workshop/www/03/eval.php`


## Bonus

Quelques idées de bonus, qu'on peut ou non mettre en place, en fonction du temps / des volontés :

 * Ré-affichage du code PHP sur la page de résultat
 * Coloration syntaxique du code PHP dans le `<textarea>`, via un truc en JS par exemple

