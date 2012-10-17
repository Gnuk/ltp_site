<?php
	use \gnk\config\Config;
	use \gnk\config\Database;
	use \gnk\database\entities\Users;
	Database::useTables();
	$em = Database::getEM();
?>