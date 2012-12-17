<?php
namespace gnk\database\entities;
use \Doctrine\Common\Collections\ArrayCollection;

require_once(realpath(dirname(__FILE__)) . '/users.php');

/**
* @Entity
*/
class ConfirmPassword
{
	/** 
	* @Id
	* @OneToOne(targetEntity="Users")
	**/
	protected $user;
	/** @Column(type="string") **/
	protected $userkey;
	
	public function __construct($user, $key){
		$this->user = $user;
		$this->userkey=sha1($key);
	}
	
	public function getUser(){
		return $this->user;
	}
	
	public function setUserKey($key){
		$this->userkey = sha1($key);
	}
}