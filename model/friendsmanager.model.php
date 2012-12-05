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
namespace gnk\model;

use \gnk\config\Model;
use \gnk\config\Config;
use \gnk\database\entities\FriendsWanted;
use \gnk\database\entities\FriendsSeeMe;

/**
* Modèle des amis
*/
class FriendsManager extends Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function addFriendWanted($login){
		$user=$this->getUsersFromId(Config::getUserId());
		$want=$this->getUsersFromName($login);
		if(count($want) == 1){
			if($this->isWanted($user[0], $want[0])){
				return false;
			}
			else{
				$friend = new FriendsWanted($user[0], $want[0]);
				$this->em->persist($friend);
				$this->em->flush();
				return true;
			}
		}
		else{
			return false;
		}
	}
	
	private function isWanted($user, $want){
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('f'))
			->from('\gnk\database\entities\FriendsWanted', 'f')
			->where('f.user = :user')
			->andWhere('f.want = :want');
		$qb->setParameters(array('user' => $user, 'seeme' => $want));
		$query = $qb->getQuery();
		$result = $query->getResult();
		if(count($result) == 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function addFriendSeeMe($login){
		$user=$this->getUsersFromId(Config::getUserId());
		$seeme=$this->getUsersFromName($login);
		if(count($seeme) == 1){
			if($this->isSeeMe($user, $seeme)){
				return false;
			}
			else{
				$friend = new FriendsSeeMe($user[0], $seeme[0]);
				$this->em->persist($friend);
				$this->em->flush();
				return true;
			}
		}
		else{
			return false;
		}
	}
	
	private function isSeeMe($user, $seeme){
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('f'))
			->from('\gnk\database\entities\FriendsSeeMe', 'f')
			->where('f.user = :user')
			->andWhere('f.seeme = :seeme');
		$qb->setParameters(array('user' => $user, 'seeme' => $seeme));
		$query = $qb->getQuery();
		$result = $query->getResult();
		if(count($result) == 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	private function getUsersFromName($name){
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('u'))
			->from('\gnk\database\entities\Users', 'u')
			->where('u.login = :name');
		$qb->setParameters(array('name' => $name));
		$query = $qb->getQuery();
		$result = $query->getResult();
		return $result;
	}
	
	private function getUsersFromId($id){
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('u'))
			->from('\gnk\database\entities\Users', 'u')
			->where('u.id = :id');
		$qb->setParameters(array('id' => $id));
		$query = $qb->getQuery();
		$result = $query->getResult();
		return $result;
	}
}

?>