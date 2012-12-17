<?php
namespace gnk\database\entities;
use \Doctrine\Common\Collections\ArrayCollection;

require_once(realpath(dirname(__FILE__)) . '/users.php');

/**
* @Entity
*/
class VerifyUsers
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
}