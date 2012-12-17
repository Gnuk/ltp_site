<?php
/*
*
* Copyright (c) 2012 OpenTeamMap
*
* This file is part of LocalizeTeaPot.
*
* LocalizeTeaPot is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* LocalizeTeaPot is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with LocalizeTeaPot.  If not, see <http://www.gnu.org/licenses/>.
*/
	namespace gnk\controller;
	use \gnk\config\Controller;
	
	class PasswordManager extends Controller{
		private $model;
		
		public function __construct(){
			$this->loadModel('passwordmanager');
			$this->model = new \gnk\model\PasswordManager();
			$this->sendPassword();
		}
		
		public function sendPassword(){
			if(isset($_POST['user'])){
				$this->model->sendPassword($_POST['user']);
			}
			return false;
		}
		
		public function isConfirm(){
			if(
				isset($_GET['id'])
				AND isset($_GET['key'])
			){
				return $this->model->isConfirm($_GET['id'], $_GET['key']);
			}
			return false;
		}
	}
?>