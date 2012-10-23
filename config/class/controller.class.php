<?php
	namespace gnk\config;
	/**
	* Gestion du contrôleur
	* @author Anthony REY <anthony.rey@mailoo.org>
	* @since 23/10/2012
	*/
	class Controller{
		/**
		* Récupère le contrôleur
		* @param string $link Le lien du contrôleur
		*/
		public static function load($link){
			$realLink = LINK_CONTROLLER . $link . '.controller.php';
			if(is_file($realLink)){
				require_once($realLink);
			}
		}
	}
?>