<?php
namespace gnk\database\entities;
use \DateTime;
use \Doctrine\Common\Collections\ArrayCollection;

require_once(realpath(dirname(__FILE__)) . '/users.php');

/**
* @Entity
*/
class FriendsSeeMe
{
	/** @Id @ManyToOne(targetEntity="Users") @JoinColumn(name="user_id", referencedColumnName="id") **/
	protected $user;
	/** @Id @ManyToOne(targetEntity="Users") @JoinColumn(name="seeme_id", referencedColumnName="id") **/
	protected $seeme;
	
	public function __construct($user, $seeme){
		$this->user = $user;
		$this->seeme = $seeme;
	}
	
	public function getUser(){
		return $this->user;
	}
	
	public function getSeeMe(){
		return $this->seeme;
	}
}