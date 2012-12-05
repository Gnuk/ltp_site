<?php

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