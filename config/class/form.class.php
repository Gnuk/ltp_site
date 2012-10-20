<?php
	namespace gnk\config;
/**
* Classe des formulaires
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 22/10/2012
* @namespace gnk\config
*/
class Form{

	/**
	* Indique si l'entrée est une adresse mail correctement constituée ou non
	* @param string $mail
	* @return boolean
	*/
	public static function isMail($mail){
		if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
			return true;
		}
		return false;
	}
}
?>