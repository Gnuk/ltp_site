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
	
	/**
	* Constructeur
	* @param string $username Le nom de l'utilisateur
	* @param string $mail L'adresse mail de l'utilisateur
	* @param string $language Le langage par défaut de l'utilisateur (vaut null si rien n'est précisé)
	*/
	public function __construct($username, $mail, $language = null){
		$this->username = $username;
		$this->mail = $mail;
		if(isset($language)){
			$this->language = $language;
		}
	}
	
	/**
	* Mise à jour du mot de passe
	* @param string Le nouveau mot de passe
	*/
	public function setPassword($password){
		$this->password = $password;
	}
	
	/**
	* Génération du tableau (en fonction de l'API REST)
	* @see toArray dans la classe Services
	* @return array Le tableau généré
	*/
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