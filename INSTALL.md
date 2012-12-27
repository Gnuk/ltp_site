# Installation du site

## License

Copyright (c) 2012 OpenTeamMap

This file is part of LocalizeTeaPot.

LocalizeTeaPot is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

LocalizeTeaPot is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with LocalizeTeaPot.  If not, see <http://www.gnu.org/licenses/>.

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

