<?php
namespace gnk\database\entities;
use \Doctrine\Common\Collections\ArrayCollection;

require_once(realpath(dirname(__FILE__)) . '/users.php');

/**
* @Entity
*/
class FriendsWanted
{
	/** @Id @ManyToOne(targetEntity="Users") @JoinColumn(name="user_id", referencedColumnName="id") **/
	protected $user;
	/** @Id @ManyToOne(targetEntity="Users") @JoinColumn(name="want_id", referencedColumnName="id") **/
	protected $want;
	
	public function __construct($user, $want){
		$this->user = $user;
		$this->want = $want;
	}
	
	public function getUser(){
		return $this->user;
	}
	
	public function getWant(){
		return $this->want;
	}
}