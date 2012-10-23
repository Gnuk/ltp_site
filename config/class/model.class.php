<?php
	namespace gnk\config;
	/**
	* Gestion du modèle
	* @author Anthony REY <anthony.rey@mailoo.org>
	* @since 23/10/2012
	*/
	class Model{
		/**
		* Récupère le modèle
		* @param string $link Le lien du modèle
		*/
		public static function load($link){
			$realLink = LINK_MODEL . $link . '.model.php';
			if(is_file($realLink)){
				require_once($realLink);
			}
		}
	}
?>