<?php
/*
*
* Copyright (c) 2012 GNKW
*
* This file is part of GNK Website.
*
* GNK Website is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* GNK Website is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with GNK Website.  If not, see <http://www.gnu.org/licenses/>.
*/
namespace gnk\database\entities;
use \Doctrine\Common\Collections\ArrayCollection;

require_once(realpath(dirname(__FILE__)) . '/users.php');

/**
* @Entity
*/
class ConfirmPassword
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
	
	public function setUserKey($key){
		$this->userkey = sha1($key);
	}
}