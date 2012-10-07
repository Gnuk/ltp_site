<?php
/**
* Gestion des modules
*/
class Module{
	public static function load($moduleName){
		require_once(LINK_MODULES . $moduleName . '/' . $moduleName . '.class.php');
	}
	public static function getLink($moduleName){
		return LINK_MODULES . $moduleName . '/';
	}
}
?>