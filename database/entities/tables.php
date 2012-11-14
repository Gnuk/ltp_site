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
	/** @Column(type="string", nullable=true)) **/
	protected $language;
	/** @Column(type="datetime") **/
	protected $date;
	/** @Column(type="boolean") **/
	protected $active=false;
	/** @Column(type="integer", nullable=true) **/
	protected $cookie;
	/** @Column(type="string", length=255, unique=true) **/
	protected $mail;
	
	public function __construct($login, $password, $mail, $language = null){
		$this->login = $login;
		$this->password = sha1($password);
		$this->mail = $mail;
		$this->rights = 3;
		if(isset($language)){
			$this->language = $language;
		}
		$datetime = new DateTime();
		$this->date = $datetime;
	}
	
	public function setMail($mail){
		$this->mail=$mail;
	}
	
	public function setActive($active){
		$this->active=$active;
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
	
	public function getLanguage(){
		return $this->language;
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
	protected $userkey;
	
	public function __construct($user, $key){
		$this->user = $user;
		$this->userkey=sha1($key);
	}
	
	public function getUser(){
		return $this->user;
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
    
    public function __construct(Users $user, $message, $longitude, $latitude)
    {
		$this->user = $user;
		$this->message = $message;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$datetime = new DateTime();
		$this->date = $datetime;
    }
    
    public function getMessage(){
		return $this->message;
    }
    
    public function getLatitude(){
		return $this->latitude;
    }
    
    public function getLongitude(){
		return $this->longitude;
    }
}