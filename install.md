# Installation du site

## Télécharger et installer

* apache (ou nginx, lighthttpd)
* php5 (ou php5-fpm)
* mysql (ou une autre base sql)
* git (msysgit)

## Installation du site

* vérifier que les messages électroniques fonctionnent depuis le php (voir php.ini)
* pointer un répertoire dans apache (on le nommera ici ltp_site)
* exécuter la commande suivante dans le répertoire pointé
~~~~~~~~~~~~~{.sh}
git clone https://github.com/Gnuk/ltp_site.git .
~~~~~~~~~~~~~
* créer une base de données (ici on la nommera ltp_site_bdd)
* remplir le fichier userconfig/db.conf.php (plus d'informations sur le site de doctrine)
* remplir si besoin le fichier doctrine.php, sinon simplement copier le fichier doctrine.php.default en doctrine.php
* exécuter dans le répertoire ltp_site
~~~~~~~~~~~~~{.sh}
php doctrine.php orm:schema-tool:create
~~~~~~~~~~~~~