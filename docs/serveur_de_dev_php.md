# Serveur PHP de développement

## Fonctionnement

Cette saison, nous allons utiliser le serveur de développement intégré à PHP.
Pour le lancer, on tape dans son terminal à la racine du dépôt la commande :
`php -S 0.0.0.0:8080 -t public`

* `-S` est utilisé pour lancer le serveur PHP de développement intégré
* `0.0.0.0` correspond à toutes les adresses IP de notre machine, ainsi, cela fonctionne y compris pour votre adresse VPN (utilisée pendant les ateliers en pair-programming)
* `8080` correspond au port utilisé (le numéro du guichet sur notre VM)
* `-t public` permet d'indiquer que le répertoire `public` correspond à la racine de notre site.

Bien qu'il n'utilise pas de fichier `.htaccess` (format de fichier spécifique à Apache), notre structure de site, avec un fichier `index.php` servant de Front Controller et l'utilisation de la réécriture d'URLs, fonctionne également avec le serveur de développement intégré PHP, car par défaut, il renvoie tout vers le fichier `index.php`.

## Pourquoi ?

Du fait que le serveur soit lancé dans le répertoire `public`, le mot `public` n'apparaît plus dans l'url. On accède directement à `localhost:8080`.

Il n'y a plus de sous-dossier dans l'url, cela ressemble un peu plus à un site en ligne.

Un autre avantage est que les fichiers et dossiers non publics (les répertoires `app` et les autres) sont mieux sécurisés car on ne peut pas remonter au delà de la racine (répertoire `public`).

## Et pour mettre le site en production ?

Si le serveur de production utilise le logiciel Apache (comme sur nos VM), alors il faudrait s'adapter et remettre en place les fichiers `.htaccess` comme on l'avait fait en S05, pour gérer le renvoi vers le Front Controller (index.php) et interdire l'accès à certains répertoires.
