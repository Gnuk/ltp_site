<?php
	use \Doctrine\ORM\EntityManager;
	use \Symfony\Component\Console\Helper\HelperSet;
	use \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
	use \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
	use \Doctrine\ORM\Tools\Console\ConsoleRunner;
	define('LINK_ROOT', realpath(dirname(__FILE__)).'/');
	define('LINK_R', '');
	define('LINK_CONFIG', LINK_ROOT . LINK_R .'config/');

	# Définition des liens
	require_once(LINK_CONFIG . 'links.php');
	require_once(LINK_CONFIG . 'class/config.class.php');
	
	$doctrineDir = 'lib/doctrine';
	require_once($doctrineDir.'/Doctrine/ORM/Tools/Setup.php');
	$doctrineDir = LINK_LIB . 'doctrine';
	require_once(LINK_CONFIG . 'include/doctrineConnect.php');
	// obtaining the entity manager
	$entityManager = EntityManager::create($conn, $config);
	
	$helperSet = new HelperSet(array(
		'db' => new ConnectionHelper($entityManager->getConnection()),
		'em' => new EntityManagerHelper($entityManager)
	));

	ConsoleRunner::run($helperSet);
?>