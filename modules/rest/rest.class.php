<?php
namespace gnk\modules\rest;
use \gnk\config\Module;
use \gnk\config\Page;
use \gnk\modules\rest\services\User;

class Rest{
	private $isApi = false;
	private $version = '1';
	protected $pathInfo = array();
	private $format = 'json';
	private $array = array();
	protected $login;
	protected $password;
	private $method;
	public function __construct(){
		$this->method = strtolower($_SERVER['REQUEST_METHOD']);
		$this->getUserInfo();
		$this->getPathInfo();
	}
	
	private function getUserInfo(){
		if(isset($_SERVER['PHP_AUTH_USER']) AND isset($_SERVER['PHP_AUTH_PW'])){
			$this->login = $_SERVER['PHP_AUTH_USER'];
			$this->password = $_SERVER['PHP_AUTH_PW'];
		}
	}
	
	private function getPathInfo(){
		$this->pathInfo = Page::getArrayPathInfo();
		if(isset($this->pathInfo[0]) AND $this->pathInfo[0] == 'api'){
			$this->isApi = true;
			if(isset($this->pathInfo[1])){
				$this->version = $this->pathInfo[1];
			}
		}
	}
	
	public function getVersion(){
		return $this->version;
	}
		
	public function getMethod(){
		return $this->method;
	}
	
	public function isApi(){
		return $this->isApi;
	}
	
	public function setArray($array){
		$this->array = $array;
	}
	
	public function get(){
		if(isset($this->format)){
			if($this->format == 'json'){
				$this->getJson();
			}
			else if($this->format == 'xml'){
				$this->getXML();
			}
		}
	}
	
	private function getJson(){
		if(count($this->array) > 0){
			header('Content-Type: application/json');
			echo json_encode($this->array);
		}
	}
	
	private function getXML($array){
		/** TODO */
	}
}

?>