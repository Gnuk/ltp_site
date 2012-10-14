<?php
	# Affichage des erreurs
	error_reporting(E_ALL);

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