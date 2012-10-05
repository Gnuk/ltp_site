<?php
	error_reporting(E_ALL);
	define('LINK_R', '');
	define('LINK_CONFIG', LINK_ROOT . LINK_R .'config/');
	require_once(LINK_CONFIG . 'links.php');
	$CLASS_DIR = opendir(LINK_CLASS);
	while(false !== ($file = readdir($CLASS_DIR))) {
		if(preg_match('#\.class\.php$#', $file))
		{
			require_once(LINK_CLASS.$file);
		}
	}
	Config::setLocales();
?>