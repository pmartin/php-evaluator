# Slot 4 : construire une image Docker

Objectifs :

 * Créer une image docker, basée sur une distribution / des paquets existant, pour simplifier les choses
 * Découvrir le principe de `Dockerfile`
 * Utiliser la commande `docker build`
 * Brancher cette image dans notre application pour éxécuter du code sur une seconde version de PHP

## Principe de construction d'une image

Jusqu'à présent, nous avons utilisé une image trouvée sur le *hub docker* : une image existante.

Maintenant, nous allons créer notre propre image, ce qui nous permettra d'y placer les logiciels
que nous voulons ; et, notamment, la version de PHP qui nous intéresse.

Nous commencerons par une image basée sur Debian Jessie (donc pas vraiment *la* version de PHP
*que nous voulons*, mais c'est un premier pas -- et une version de PHP installée sur de nombreux serveurs).

Construire une image docker, ça passe par :

 * Un fichier `Dockerfile`, qui décrit l'image et sa construction ; typiquement par une série de commandes apt-get
 * La commande `docker build` pour construire l'image, à partir du `Dockerfile`


## Un fichier Dockerfile

Cf `workshop/www/04/Dockerfile`

Dans les grandes lignes :

 * On se base sur `debian:jessie` (la version `stable` en ce moment)
 * On installe `php5-cli` (jessie fournit PHP 5.6)


## Construire notre image

Avant de commencer, on peut lister les images que nous avons en local :

```bash
docker images
```

On utilise la commande `docker build`, depuis le répertoire où se trouve notre `Dockerfile` :

```bash
cd /var/www/04/
docker build --rm --tag=php-jessie .
```

Et essayons d'utiliser cette image :

```bash
docker run php-jessie php --version
```

On voit qu'on a une version de PHP 5.6 installée et disponible ;-)


## Branchement dans notre application

Il ne reste plus qu'à adapter un peu notre classe `Evaluator` pour qu'elle sache fonctionner avec
différentes images docker (typiquement, en spécifiant l'image à utiliser lors de l'appel du constructeur).

Et ensuite, une boucle dans notre script `eval.php`, pour appeler `Evaluator` sur chacune des versions
de PHP (et images correspondantes) qui nous intéressent + revoir l'affichage des résultats.

Un premier exemple de code PHP, qui doit fonctionner en 5.6 et en 7.0 :

```php
printf("Version de PHP utilisée : %s", PHP_VERSION);
```

Et un second exemple, qui doit fonctionner en PHP 7.0 mais pas 5.6 :

```php
function hello(string $who)
{
    printf("Hello, %s!", $who);
}

hello("World");
```
