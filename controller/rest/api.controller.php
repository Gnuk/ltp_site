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
	
	public function launchUser(){
		if($this->getMethod() == 'get'){
			$user = new User('Hello', 'World');
			$this->setArray($user->toArray());
			$this->get();
		}
	}
	
	public function launchStatuses(){
		if($this->getMethod() == 'get'){
			if(isset($this->login) AND count(isset($this->password)) == 1){
				if($this->model->getUserProfile($this->login, $this->password)){
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
				echo Page::setHTTPCode(404);
			}
		}
	}
}
?>