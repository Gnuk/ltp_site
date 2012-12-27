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

namespace gnk\config;


/**
* Gère la base de donnée du site
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 06/10/2012
* @namespace gnk\config
* @extends gnk\config\Config
*/
class Database extends Config{
	/**
	* Récupère l'entity Mannager
	*/
	public static function getEM(){
		return self::$em;
	}
	
	/**
	* Appelle les entités
	*/
	public static function useTables(){
		$entitiesDir = opendir(LINK_DATABASE . 'entities/');
		while(false !== ($file = readdir($entitiesDir))) {
			if(preg_match('#.php$#', $file))
			{
				require_once(LINK_DATABASE . 'entities/' . $file);
			}
		}
	}
}
?>