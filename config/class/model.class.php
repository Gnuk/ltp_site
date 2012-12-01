<?php
	namespace gnk\config;
	/**
	* Gestion du modèle
	* @author Anthony REY <anthony.rey@mailoo.org>
	* @since 23/10/2012
	*/
	class Model{
	
		private $indications = array();
		private $errors = array();
		protected $em;

		/**
		* Constructeur
		*/
		public function __construct(){
			Database::useTables();
			$this->em = Database::getEM();
		}
		
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
		
		protected function addIndication($indication){
			$this->indications[] = $indication;
		}
		
		protected function addError($error){
			$this->errors[] = $error;
		}
		
		/**
		* Récupère les erreurs envoyées
		*/
		public function getErrors(){
			return $this->errors;
		}
		
		/**
		* Récupère les indications envoyées
		*/
		public function getIndications(){
			return $this->indications;
		}
	}
?>