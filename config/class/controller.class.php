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
	use \gnk\config\Model;
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
		
		public function loadModel($name){
			Model::load($name);
		}
	}
?>