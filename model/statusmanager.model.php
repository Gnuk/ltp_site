<?php
	namespace gnk\model;
	use \gnk\config\Database;
	use \gnk\config\Config;
	use \gnk\database\entities\Users;
	use \gnk\database\entities\Status;
	
	class StatusManager{
		private $message;
		private $longitude;
		private $latitude;
		private $user;
		public function __construct(){
			Database::useTables();
			$this->em = Database::getEM();
			$this->id = Config::getUserId();
		}
		
		public function getStatuses(){
			$qb = $this->em->createQueryBuilder();
			$qb->select(array('s.longitude', 's.latitude', 's.message'))
				->from('\gnk\database\entities\Status', 's')
				->where('s.user = :id')
				->orderBy('s.date', 'DESC')
				->setMaxResults(5);
			$qb->setParameters(array('id' => $this->id));
			$query = $qb->getQuery();
			$result = $query->getResult();
			return $result;
		}
		
		public function addStatus($message, $longitude, $latitude){
			$this->message = $message;
			$this->longitude = $longitude;
			$this->latitude = $latitude;
			if($this->getUser()){
				$status = new Status($this->user, $message, $latitude, $longitude);
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
	}
?>