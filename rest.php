<?php
	use \gnk\config\Page;
	use \gnk\config\Controller;
	use \gnk\controller\rest;
	define('LINK_ROOT', realpath(dirname(__FILE__)).'/');
	require_once(LINK_ROOT . 'config/config.php');
	Controller::load('rest/api');
	$api = new Api();
	$api->run();
?>