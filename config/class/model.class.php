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