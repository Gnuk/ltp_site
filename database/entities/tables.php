<?php
namespace gnk\database\entities;
use \DateTime;
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
	/** @Column(type="string", length=255) **/
	protected $password;
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
	
	public function __construct($login, $password, $mail){
		$this->login = $login;
		$this->password = sha1($password);
		$this->mail = $mail;
		$this->rights = 3;
		$datetime = new DateTime();
		$this->date = $datetime;
	}
	
	public function setMail($mail){
		$this->mail=$mail;
	}
	
	public function getLogin(){
		return $this->login;
	}
	
	public function getRights(){
		return $this->rights;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getActive(){
		return $this->active;
	}
}

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
	protected $key;
	
	public function __construct($user){
		$this->user = $user;
	}
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
	/** @Column(type="datetime") **/
    protected $date;
    /** @ManyToOne(targetEntity="Users") **/
    protected $user;
    
    public function __construct(User $user)
    {
		$this->user = $user;
    }
}