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
	use \gnk\config\Config;
	use \gnk\config\Model;
	use \gnk\database\entities\Users;
	use \gnk\database\entities\Statuses;
	
	/**
	* Modèle des statuts
	* @author Anthony REY <anthony.rey@mailoo.org>
	*/
	class StatusManager extends Model{
		private $message;
		private $longitude;
		private $latitude;
		private $user;
		private $id;
		
		public function __construct(){
			parent::__construct();
			$this->id = Config::getUserId();
		}
		
		public function getStatuses(){
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('s.longitude', 's.latitude', 's.message', 's.id', 's.date'))
				->from('\gnk\database\entities\Statuses', 's')
				->where('s.user = :id')
				->orderBy('s.date', 'DESC')
				->setMaxResults(5);
			$qb->setParameters(array('id' => $this->id));
			$query = $qb->getQuery();
			$result = $query->getResult();
			return $result;
		}
		
		public function editStatus($id, $message){
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('s'))
				->from('\gnk\database\entities\Statuses', 's')
				->where('s.user = :user')
				->andWhere('s = :id')
				->orderBy('s.date', 'DESC')
				->setMaxResults(5);
			$qb->setParameters(array('user' => $this->id, 'id' => $id));
			$query = $qb->getQuery();
			$result = $query->getResult();
			if(count($result) == 1){
				$result[0]->setMessage($message);
				$this->em->flush();
			}
			else{
				$this->addError(T_('Impossible d\'éditer ce statut, peut-être ne vous appartient-t-il pas ?'));
				return false;
			}
		}
		
		public function getStatusMessage($id){
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('s.message'))
				->from('\gnk\database\entities\Statuses', 's')
				->where('s.user = :user')
				->andWhere('s = :id')
				->orderBy('s.date', 'DESC')
				->setMaxResults(5);
			$qb->setParameters(array('user' => $this->id, 'id' => $id));
			$query = $qb->getQuery();
			$result = $query->getResult();
			if(count($result) == 1){
				return $result[0]['message'];
			}
			else{
				return '';
			}
		}
		
		public function addStatus($message, $longitude, $latitude){
			$this->message = $message;
			$this->longitude = $longitude;
			$this->latitude = $latitude;
			if($this->getUser()){
				$status = new Statuses($this->user, $message, $longitude, $latitude);
				$this->user->setLonLat($longitude, $latitude);
				$this->em->persist($status);
				$this->em->flush();
				return true;
			}
			else{
				$this->addError(T_('L\'utilisateur n\'existe pas'));
				return false;
			}
		}
		
		private function getUser(){
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('u'))
				->from('\gnk\database\entities\Users', 'u')
				->where('u.id = :id');
			$qb->setParameters(array('id' => $this->id));
			$query = $qb->getQuery();
			$result = $query->getResult();
			if(count($result) == 1){
				$this->user = $result[0];
				return true;
			}
			return false;
		}
		
		public function delStatus($id){
			$this->getUser();
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('s'))
				->from('\gnk\database\entities\Statuses', 's')
				->where('s.id = :id')
				->andWhere('s.user = :user');
			$qb->setParameters(array('id' => $id, 'user' => $this->user));
			$query = $qb->getQuery();
			$result = $query->getResult();
			if(count($result) == 1){
				$this->em->remove($result[0]);
				$this->em->flush();
				return true;
			}
			else{
				$this->addError(T_('Impossible de supprimer ce message'));
				return false;
			}
		}
	}
?>