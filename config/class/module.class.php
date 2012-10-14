<?php
namespace gnk\config;
/**
* Gestion des modules
* @author Anthony Rey <anthony.rey@mailoo.org>
* @namespace gnk\config
*/
class Module{
	public static function load($moduleName){
		require_once(LINK_MODULES . $moduleName . '/' . $moduleName . '.class.php');
	}
	public static function getLink($moduleName){
		return LINK_MODULES . $moduleName . '/';
	}
	public static function getRLink($moduleName){
		return LINKR_MODULES . $moduleName . '/';
	}
}
?>