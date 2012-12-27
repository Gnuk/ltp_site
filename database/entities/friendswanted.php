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
use \Doctrine\Common\Collections\ArrayCollection;

require_once(realpath(dirname(__FILE__)) . '/users.php');

/**
* @Entity
*/
class FriendsWanted
{
	/** @Id @ManyToOne(targetEntity="Users") @JoinColumn(name="user_id", referencedColumnName="id") **/
	protected $user;
	/** @Id
	* @ManyToOne(targetEntity="Users")
	* @JoinColumn(name="want_id", referencedColumnName="id")
	*/
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