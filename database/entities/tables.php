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
	
	/**
	* @OneToMany(targetEntity="FriendsWanted", mappedBy="user")
	*/
	private $wantme;
	
	/**
	* @OneToMany(targetEntity="FriendsWanted", mappedBy="want")
	*/
	private $wanted;

	/**
	* @OneToMany(targetEntity="FriendsSeeMe", mappedBy="seeme")
	*/
	private $seeme;
	
	
	/**
	* @OneToMany(targetEntity="FriendsSeeMe", mappedBy="user")
	*/
	private $isee;

	/**
	* @OneToMany(targetEntity="Statuses", mappedBy="id")
	*/
	private $statuses;
	
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
	
	public function getStatuses(){
		return $this->statuses;
	}
	
	public function getSeeMe(){
		return $this->seeme;
	}
	
	public function getIWant(){
		return $this->iwant;
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
	
	public function getMail(){
		return $this->mail;
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

/**
 * @Entity
 **/
class Statuses
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
    /** @ManyToOne(targetEntity="Users") @JoinColumn(name="user_id", referencedColumnName="id") **/
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