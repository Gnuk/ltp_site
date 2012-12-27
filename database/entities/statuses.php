<?php
/*
*
* Copyright (c) 2012 OpenTeamMap
*
* This file is part of LocalizeTeaPot.
*
* LocalizeTeaPot is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* LocalizeTeaPot is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with LocalizeTeaPot.  If not, see <http://www.gnu.org/licenses/>.
*/
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