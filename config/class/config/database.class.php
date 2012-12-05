<?php
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