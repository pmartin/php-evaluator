# Slot 1 : introduction, premiers pas

## Introduction, présentation

On a 3h d'atelier devant nous, qu'on va essayer de découper en 6 slots de 25-30 minutes chacun,
y compris le slot qu'on est tout juste en train de commencer ;-)

Chaque slot vise à couvrir un point de l'atelier, avec une sorte de *ckeckpoint* disponible à la fin
de chaque slot et avant d'attaquer le suivant, généralement sous forme de code sur github, pour éviter
de rester bloqué si vous avez eu un problème sur un slot.

### Objectifs

 * Du PHP
 * Utiliser un peu docker
 * Faire un truc un peu *fun*

### Application qu'on va développer

 * Site web qui permet de saisir une portion de code PHP
 * et d'avoir les sorties (stdout et stderr) obtenues (+ code statut) avec plusieurs versions de PHP

### Comment va-t-on procéder ?

 * Dans une machine virtuelle
    * pour que tout le monde ait un Linux qui sait faire tourner Docker, ça simplifiera le setup
    * en utilisant Vagrant, pour simplifier le setup / provisionning
 * Un serveur nginx + php-fpm
 * Strockage : MySQL ? Redis ?
 * Une page web "formulaire"
 * Plusieurs images docker pour exécuter le code PHP
    * sous plusieurs versions de PHP
    * en *isolation* par rapport au système (la VM) qu'on ne souhaite pas toucher

### Un atelier de durée limitée

On n'a que 3h d'atelier, on ne pourra donc pas développer une application *parfaite* et totalement *terminée*.

Quelques points qu'on ne traitera (très probablement) pas :

 * Sauvegarde des résultats obtenus
 * Sauvegarde des portions de code PHP ?
 * Full-docker *pour tout* ; on garde, aujourd'hui, certains composants sur la VM et pas dans des containers :
    * Base de données (MySQL / Redis)
    * nginx + php-fpm pour l'interface
 * Queue d'exécution en arrière-plan (RabbitMQ ?)
 * Exécution du code PHP via appels Ajax, sans attendre le re-chargement de la page ?


## Installation des composants requis

Normalement, tout le monde a récupéré la VM => il ne devrait pas rester grand chose à faire.

Dans la VM en question, on a (en avril 2016 => ça a pu évoluer légérement depuis) :

 * Ubuntu 16.04 LTS (toute dernière version ;-) )
 * PHP 7.0(.4)
 * nginx 1.9(.15)
 * docker 1.10(.3)

Vérification "est-ce que ça marche ?" :

 * Lancer la machine, ça exécutera le provisionning (installation des logiciels + config) : `vagrant up`
 * Connexion SSH à la machine : `vagrant ssh`
 * Lister les images docker (quelques unes ont été récupérées pendant le provisionning) : `docker images`
 * Exécuter un programme via un container : `docker run hello-world`
 * Afficher le script `phpinfo.php` via un navigateur (et donc via nginx + fpm) => PHP fonctionne sur la VM
 * Appeler le script `docker.php` via un navigateur => PHP peut appeler `docker`


## Exécuter du code PHP

Pour finir, exécutons une portion de code PHP au sein d'un conteneur.

### Code en ligne

Avant de passer à l'exécution dans le container, exécutons en local sur la VM :

```bash
php -r 'var_dump(PHP_VERSION);'
```

Puis passons à l'exécution de code PHP dans un container, avec en premier une instruction *en ligne*,
via l'option `-r` du programme `php` :

```bash
docker run php:7.0-cli php -r 'var_dump(PHP_VERSION);'
```

### Code sur l'entrée standard

C'est pratique, mais pas hyper souple. Pour s'interfacer depuis un script appelant le container
pour exécuter du code, on préférerait envoyer ce code sur l'entrée standard ;-)

Exemple sans docker (note : il faut la balise `<?php` ouvrante, ici !) :

```bash
echo '<?php echo PHP_VERSION, "\n"; ?>' | php
```

Et avec docker :

```bash
echo '<?php echo PHP_VERSION, "\n"; ?>' | docker run -i php:7.0-cli php
```

Attention : il faut l'option `-i` de `docker run`, pour être en mode *interactif*.

Et pour éviter de garder un container non supprimé, on peut ajouter l'option `--rm` :

```bash
echo '<?php echo PHP_VERSION, "\n"; ?>' | docker run -i --rm php:7.0-cli php
```
