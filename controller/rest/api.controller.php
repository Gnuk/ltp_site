<?php
use \gnk\config\Module;
use \gnk\config\Model;
use \gnk\config\Page;
use \gnk\modules\rest\Rest;
use \gnk\controller\rest\services\User;
use \gnk\controller\rest\services\Statuses;
use \gnk\model\RestManager;
Module::load('rest');
Model::load('restmanager');
require_once(LINK_CONTROLLER . 'rest/services.class.php');

class Api extends Rest{
	public function __construct(){
		parent::__construct();
	}
	
	public function run(){
		$this->model = new \gnk\model\RestManager();
		if($this->isApi() AND isset($this->pathInfo[2])){
			switch($this->pathInfo[2]){
				case 'user':
					$this->launchUser();
					break;
				case 'statuses':
					$this->launchStatuses();
					break;
			}
		}
	}
	
	/**
	* 
	*/
	public function launchUser(){
		if($this->getMethod() == 'get'){
			if(isset($this->login) AND isset($this->password)){
				$profile = $this->model->getUserProfile($this->login, $this->password);
				if(count($profile) == 1){
					if(isset($profile[0]['language'])){
						$user = new User($profile[0]['login'], $profile[0]['mail'], $profile[0]['language']);
					}
					else{
						/**
						* Si l'utilisateur n'a pas de langage définit
						*/
						$user = new User($profile[0]['login'], $profile[0]['mail']);
					}
					$this->setArray($user->toArray());
					$this->get();
				}
				else{
					/**
					* Authentification refusée
					*/
					Page::setHTTPCode(403);
				}
			}
			else{
				/**
				* Page introuvable
				*/
				Page::setHTTPCode(404);
			}
		}
		if($this->getMethod() == 'post'){
			echo 'Pas implémenté';
		}
	}
	
	/**
	* 
	*/
	public function launchStatuses(){
		if($this->getMethod() == 'get'){
			if(isset($this->login) AND isset($this->password)){
				if(count($this->model->getUserProfile($this->login, $this->password)) == 1){
					$statuses = $this->model->getStatuses($this->login, $this->password);
					if(count($statuses) > 0){
						$rest = new Statuses($statuses);
						$this->setArray($rest->toArray());
						$this->get();
					}
					else{
						/**
						* Aucun contenu
						*/
						Page::setHTTPCode(204);
					}
				}
				else{
					/**
					* Authentification refusée
					*/
					Page::setHTTPCode(403);
				}
			}
			else{
				/**
				* Page introuvable
				*/
				Page::setHTTPCode(404);
			}
		}
		if($this->getMethod() == 'post'){
			echo 'Pas implémenté';
		}
	}
}
?>