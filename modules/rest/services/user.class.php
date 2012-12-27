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
namespace gnk\modules\rest\example\services;

/**
* Exemple de classe Utiisateur pour REST
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 28/11/2012
* @see Services
* @namespace gnk\modules\rest\example\services
*/
class User extends \gnk\modules\rest\example\Services{
	private $username;
	private $mail;
	private $password;
	private $language;
	
	public function __construct($username, $mail, $language = null){
		$this->username = $username;
		$this->mail = $mail;
		if(isset($language)){
			$this->language = $language;
		}
	}
	
	public function setPassword($password){
		$this->password = $password;
	}
	
	public function toArray(){
		if(count($this->serviceArray) == 0){
			parent::toArray();
			$this->serviceArray['rest']['profil']['username'] = $this->username;
			$this->serviceArray['rest']['profil']['mail'] = $this->mail;
			if(isset($this->language)){
				$this->serviceArray['rest']['profil']['language'] = 'fr';
			}
			else{
				$this->serviceArray['rest']['profil']['language'] = 'default';
			}
		}
		return $this->serviceArray;
	}
}

?>