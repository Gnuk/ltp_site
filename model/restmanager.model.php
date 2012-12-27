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

/**
* Modèle de REST
* @author Anthony REY <anthony.rey@mailoo.org>
*/
class RestManager extends Model{
	private $maxRestult = 30;
		
	/**
	* Constructeur
	*/
	public function __construct(){
		parent::__construct();
	}
	
	public function getUser($login, $password){
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('u'))
			->from('\gnk\database\entities\Users', 'u')
			->where('u.login LIKE ?1')
			->andWhere('u.active = ?2')
			->andWhere('u.password LIKE ?3');
		$qb->setParameters(array(1 => $login, 2 => true, 3 => sha1($password)));
		$query = $qb->getQuery();
		$result = $query->getResult();
		return $result;
	}
	
	public function getUserProfile($login, $password){
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('u.id', 'u.login', 'u.language', 'u.mail'))
			->from('\gnk\database\entities\Users', 'u')
			->where('u.login LIKE ?1')
			->andWhere('u.active = ?2')
			->andWhere('u.password LIKE ?3');
		$qb->setParameters(array(1 => $login, 2 => true, 3 => sha1($password)));
		$query = $qb->getQuery();
		$result = $query->getResult();
		return $result;
	}
	
	public function getStatuses($id){
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('s.longitude', 's.latitude', 's.message', 's.date'))
			->from('\gnk\database\entities\Statuses', 's')
			->leftJoin('\gnk\database\entities\Users', 'u', 'WITH', 's.user = u.id')
			->where('u = ?1')
			->orderBy('s.date', 'DESC')
			->setMaxResults($this->maxRestult);
		$qb->setParameters(array(1 => $id));
		$query = $qb->getQuery();
		$result = $query->getResult();
		return $result;
	}
	
	public function getFriends($id){
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('u'))
			->from('\gnk\database\entities\Users', 'u')
			->leftJoin('u.wanted', 'w')
			->leftJoin('u.isee', 's')
			->where('w.user = :id')
			->andWhere('w.user = s.seeme')
			->orderBy('u.login', 'ASC');
		$qb->setParameters(array('id' => $id));
		$query = $qb->getQuery();
		$result = $query->getResult();
		if(count($result) > 0){
			return $result;
 		}
 		else{
			return array();
 		}
	}
}
?>