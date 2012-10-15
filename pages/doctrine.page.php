<?php
	use \gnk\config\Config;
	use \gnk\config\Database;
	use \gnk\database\entities\Users;
	Database::useTables();
	echo T_("Welcome to Doctrine");
	$em = Database::getEM();
?>