<?php
use \gnk\config\Module;
use \gnk\config\Model;
use \gnk\modules\rest\Rest;
use \gnk\controller\rest\services\User;
use \gnk\model\RestManager;
Module::load('rest');
Model::load('restmanager');
require_once(LINK_CONTROLLER . 'rest/services.class.php');

class Api extends Rest{
	private $rest;
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
			echo 'Not Implemented !';
		}
	}
}
?>