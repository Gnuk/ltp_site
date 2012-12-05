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

namespace gnk\controller\rest\services;

/**
* Classe Utilisateur pour REST
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 28/11/2012
* @see Services
* @namespace gnk\controller\rest\services
*/
class User extends \gnk\controller\rest\Services{
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
			$this->serviceArray['ltp']['profile']['username'] = $this->username;
			$this->serviceArray['ltp']['profile']['mail'] = $this->mail;
			if(isset($this->language)){
				$this->serviceArray['ltp']['profile']['language'] = $this->language;
			}
		}
		return $this->serviceArray;
	}
}

?>