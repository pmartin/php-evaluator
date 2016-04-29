
Plan de l'atelier, dans les grandes lignes, slot par slot :

 1. Introduction, premiers pas
    * Objectifs de l'atelier
    * Composants requis et leur installation
    * Exécuter du code PHP, y compris dans un docker
 2. Exécuter du PHP depuis PHP-FPM
    * Un premier exemple d'exécution de PHP via docker, depuis FPM
    * Une classe qui exécute du code PHP via un container docker
 3. Une interface web pour exécuter du PHP
    * Un formulaire avec un `<textarea>` pour saisir ce code
    * Un script de branchement
 4. Construire notre propre container
    * Concept de `Dockerfile` + commande `docker build`
    * Construction *simple* en utilisant des paquets existant : debian jessie
    * Utilisation dans notre application
 5. Sécuriser un minimum
    * Laisser n'importe qui exécuter du code = risque ; quelques exemples
    * Sécurisation au niveau de PHP : quelques points de configuration + sécurisée
    * Sécuration au niveau de docker : quelques limites qu'on peut mettre en place
 6. Construire une version personnalisée de PHP
    * Ne pas dépendre des versions packagées par les distributions et pouvoir utiliser n'importe quelle version, y compris versions de dev
    * Un docker pour construire + exécuter ?
    * Un docker pour construire + un autre pour exécuter
    * Ajouter notre nouvelle version de PHP à celles déjà exécutées plus haut
 7. Exécution du code en asynchrone
    * Une mini-introduction à ReactPHP et plus particulièrement `reactphp/child-process`
    * Parallélisation de l'exécution du code sur les différentes images
    * Tant que l'exécution n'est pas limitée par les CPUs de la machine, on y gagne en temps

Quelques autres idées de slots :

 * Persistance
    * MySQL ?
    * Redis ? Se préterait bien aux besoins, ici ;-)
 * Exécuter le code sur plusieurs versions de PHP en parallèle
    * React-PHP permet ça, par exemple, ça ferait une introduction sympa
 * Exécuter le code en arrière-plan
    * La page de résultats s'affiche immédiatement
    * Communication client-server pour présenter les résultats au fur et à mesure qu'ils arrivent
