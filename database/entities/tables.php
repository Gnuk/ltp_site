<?php
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 **/
class Users
{
	/** 
	* @Id 
	* @Column(type="integer")
	* @GeneratedValue(strategy="AUTO")
	**/
	protected $id;
	/** @Column(type="string", length=255, unique=true) **/
	protected $login;
	/** @Column(type="integer") **/
	protected $rights;
	/** @Column(type="datetime") **/
	protected $date;
	/** @Column(type="boolean") **/
	protected $active=false;
	/** @Column(type="integer", nullable=true) **/
	protected $cookie;
	/** @Column(type="string", length=255, unique=true) **/
	protected $mail;
	/** @Column(type="string", length=255, nullable=true) **/
	protected $key;
}

/**
* @Entity
*/
class Friends
{
	/** @Id @ManyToOne(targetEntity="Users") @JoinColumn(name="user_id", referencedColumnName="id") **/
	protected $user;
	/** @Id @ManyToOne(targetEntity="Users") @JoinColumn(name="friend_id", referencedColumnName="id") **/
	protected $friend;
	/** @Column(type="boolean") **/
	protected $show;
	
	public function __construct($user, $friend, $show=false){
		$this->user = $user;
		$this->friend = $friend;
		$this->show = false;
	}
}

/**
 * @Entity
 **/
class Status
{
    /**
    * @Id
    * @Column(type="integer")
    * @GeneratedValue 
    **/
    protected $id;
    /** @Column(type="float") **/
    protected $longitude;
    /** @Column(type="float") **/
    protected $latitude;
	/** @Column(type="text") **/
    protected $message;
    /** @ManyToOne(targetEntity="Users") **/
    protected $user;
    
    public function __construct(User $user)
    {
		$this->user = $user;
    }
}