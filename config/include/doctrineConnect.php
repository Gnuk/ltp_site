<?php
	use \gnk\config\Config;
	use \Doctrine\ORM\Tools\Setup;
	require_once($doctrineDir.'/Doctrine/ORM/Tools/Setup.php');
	$lib = $doctrineDir;
	Setup::registerAutoloadDirectory($lib);
	
	$isDevMode = true;
	
	$config = Setup::createAnnotationMetadataConfiguration(array(LINK_DATABASE."entities"), $isDevMode);

	// database configuration parameters
	$dbConf=LINK_USERCONFIG . 'db.conf.php';
	$dbConfDefault=LINK_USERCONFIG . 'db.conf.default.php';
	if(is_file($dbConf)){
		$conn = Config::getConfigFile($dbConf);
		Config::setDbConfig(true);
	}
	else if(is_file($dbConfDefault)){
		$conn = Config::getConfigFile($dbConfDefault);
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