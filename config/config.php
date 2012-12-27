<?php
/*
*
* Copyright (c) 2012 GNKW
*
* This file is part of GNK Website.
*
* GNK Website is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* GNK Website is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with GNK Website.  If not, see <http://www.gnu.org/licenses/>.
*/
	# Affichage des erreurs
	error_reporting(E_ALL);
	date_default_timezone_set('Europe/Paris');

	# Définition des liens utiles pour trouver la banque de liens
	define('LINK_R', '');
	define('LINK_CONFIG', LINK_ROOT . LINK_R .'config/');

	# Définition des liens
	require_once(LINK_CONFIG . 'links.php');

	# Import des classes
	$CLASS_DIR = opendir(LINK_CONFIG . 'class/');
	while(false !== ($file = readdir($CLASS_DIR))) {
		if(preg_match('#\.class\.php$#', $file))
		{
			require_once(LINK_CONFIG . 'class/' . $file);
		}
	}
	gnk\config\Config::setConfig();
?>