<?php
namespace gnk\database\entities;
use \DateTime;
use \Doctrine\Common\Collections\ArrayCollection;

require_once(realpath(dirname(__FILE__)) . '/users.php');

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
    /** @ManyToOne(targetEntity="Users") @JoinColumn(name="user_id", referencedColumnName="id", nullable=false) **/
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
    
    public function setMessage($message){
		$this->message = $message;
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