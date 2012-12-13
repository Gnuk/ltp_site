<?php
namespace gnk\modules\rest\example;
use \gnk\config\Module;
use \gnk\config\Config;
use \gnk\config\Page;

/**
* Exemple de gestion des services Rest
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 28/11/2012
* @see Rest
* @namespace gnk\modules\rest
*/
abstract class Services{
	protected $serviceArray = array();
	
	protected function toArray(){
		$global = Config::getWebsiteConfig();
		if(isset($global['title'])){
			$title = $global['title'];
		}
		else{
			$title = T_('Mon site');
		}
		$this->serviceArray['rest']['application']=$title;
	}
}

?>