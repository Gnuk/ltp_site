<?php
	use \gnk\config\Config;
	use \Doctrine\ORM\Tools\Setup;
	require_once($doctrineDir.'/Doctrine/ORM/Tools/Setup.php');
	$lib = $doctrineDir;
	Setup::registerAutoloadDirectory($lib);
	// Create a simple "default" Doctrine ORM configuration for XML Mapping
	$isDevMode = true;
	//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
	// or if you prefer yaml or annotations
	$config = Setup::createAnnotationMetadataConfiguration(array(LINK_DATABASE."entities"), $isDevMode);
	//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

	// database configuration parameters
	$dbConf=LINK_USERCONFIG . 'db.conf';
	if(is_file($dbConf)){
		$conn = Config::getConfigFile($dbConf);
	}
	else{
		$conn = array(
			'driver' => 'pdo_mysql',
			'user' => 'root',
			'password' => '',
			'dbname' => 'gnuk_database'
		);
	}
?>