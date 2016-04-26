Bonjour,

# Introduction <a name="introduction"></a>

Pour l'atelier de samedi, nous aurons environ 3h devant nous. Pour en profiter au maximum, je vous propose d'effectuer
une partie de l'installation avant de venir, cela nous permettra d'attaquer efficacement dès le début de la journée.

Pour réduire les différences entre les différents postes de chacun, nous travaillerons dans une machine virtuelle. Pour 
faciliter la mise en place de celle-ci, nous utiliserons Vagrant, avec un script de provisionning qui installera tout
ce dont nous avons besoin pour commencer l'atelier.

# Checklist <a name="checklist"></a>

Pour résumer les grandes lignes :

 * [Télécharger et installer VirtualBox](#virtualbox)
 * [Télécharger et install Vagrant](#vagrant)
 * [Installer le plugin vagrant-vbguest](#vbguest)
 * [Obtention des sources du projet, incluant les scripts de provisionning](#sources)
 * [Lancer le provisionning de la machine virtuelle](#provisionning)
 * [Vérifier le bon fonctionnement de la machine virtuelle](#verifications)
 * [Eteindre la machine virtuelle](#eteindre-vm)

# Installation de VirtualBox <a name="virtualbox"></a>

La machine virtuelle avec laquelle nous travaillerons tourne sous [VirtualBox](https://www.virtualbox.org/). Vous devez 
donc [télécharger et installer VirtualBox](https://www.virtualbox.org/wiki/Downloads).

# Installation Vagrant <a name="vagrant"></a>

Nous ne manipulerons pas cette VM *à la main* et utiliserons [Vagrant](https://www.vagrantup.com/) pour automatiser.
Vous devez donc [télécharger](https://www.vagrantup.com/downloads.html) et 
[installer](https://www.vagrantup.com/docs/installation/) Vagrant.

## Plugin vbguest <a name="vbguest"></a>

Vous aurez également besoin du plugin [vagrant-vbguest](https://github.com/dotless-de/vagrant-vbguest), que vous devez
installer avec la commande suivante :

```
vagrant plugin install vagrant-vbguest
```

# Obtention des sources du projet <a name="sources"></a>

Le script de provisionning et les fichiers de configuration qu'il utilise sont disponibles par le biais du projet
Github suivant : [pmartin/php-evaluator](https://github.com/pmartin/php-evaluator/)

Vous devez donc obtenir ce projet :

 * Soit en utilisant `git clone` en ligne de commande
 * Soit en utilisant un outil graphique comme le client [GitHub Desktop](https://desktop.github.com/)

Une fois les sources obtenues, vous devriez notamment avoir :

 * Un fichier `Vagrantfile`, sur lequel Vagrant se basera à l'étape suivante
 * Un répertoire `vagrant-files` qui contient notamment le script que Vagrant lancera pour installer la VM

Notes : 

 * je suis encore en train de préparer cet atelier, les sources sont donc un peu *désorganisées*, mais ça ira mieux
   d'ici samedi ;-)
 * Vous n'avez pas besoin de fouiller dans les sources et exemples : c'est le contenu de l'atelier, sur lequel nous
   nous beserons samedi ;-)

# Lancer le provisionning <a name="provisionning"></a>

Une fois les sources obtenues, placeez-vous, en ligne de commandes, dans le répertoire les contenant, puis lancez la
commande `vagrant up` *(à vous d'adapter le chemin dans la commande ci-dessous)* :

```
cd c:\dev\php-evaluator
vagrant up
```

Ceci va créer la machine virtuelle et lancer son script d'installation, qui téléchargera et installera pas mal de choses
dedans (nous en parlerons rapidement samedi).

# Vérifier le bon fonctionnement de la machine virtuelle <a name="verifications"></a>

Une fois le provisionning terminé, la machine virtuelle est lancée ; vérifiez que vous pouvez vous y connecter en SSH :

```
vagrant ssh
```

Depuis votre poste de développement, vous devez aussi avoir accès en HTTP à une page dans la machine : 
[http://localhost:49080/01/phpinfo.php](phpinfo.php)

# Eteindre la machine virtuelle <a name="eteindre-vm"></a>

Il ne vous reste plus qu'à éteindre la machine virtuelle :

```
cd c:\dev\php-evaluator
vagrant halt
```

# Et maintenant ? <a name="et-maintenant"></a>

Si vous avez des questions ou rencontrez des difficultés, n'hésitez pas à me faire signe, soit par mail, soit en DM
sur [@pascal_martin](https://twitter.com/pascal_martin) si vous n'avez pas mon mail.

Dans tous les cas, à samedi !
