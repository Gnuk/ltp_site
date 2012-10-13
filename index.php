<?php
	define('LINK_ROOT', realpath(dirname(__FILE__)).'/');
	require_once(LINK_ROOT . 'config/config.php');
	\gnk\Page::show();
?>