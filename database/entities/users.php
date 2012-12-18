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
	/** @Column(type="float", nullable=true) **/
	protected $longitude;
	/** @Column(type="float", nullable=true) **/
	protected $latitude;
	/** @Column(type="datetime", nullable=true) **/
	protected $trackdate;
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
	* @OneToMany(targetEntity="Statuses", mappedBy="user")
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
	
	public function setLonLat($longitude, $latitude){
		$this->longitude = $longitude;
		$this->latitude = $latitude;
		$this->trackdate = new DateTime();
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
	
	public function setPassword($password){
		$this->password = sha1($password);
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
	
	public function getLongitude(){
		return $this->longitude;
	}
	
	public function getLatitude(){
		return $this->latitude;
	}
	
	public function getTrackDate(){
		return $this->trackdate;
	}
}