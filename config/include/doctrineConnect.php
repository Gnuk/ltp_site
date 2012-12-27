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