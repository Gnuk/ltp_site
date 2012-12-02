<?php
	namespace gnk\model;
	use \gnk\config\Config;
	use \gnk\config\Model;
	use \gnk\database\entities\Users;
	use \gnk\database\entities\Statuses;
	
	class StatusManager extends Model{
		private $message;
		private $longitude;
		private $latitude;
		private $user;
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
		
		public function addStatus($message, $longitude, $latitude){
			$this->message = $message;
			$this->longitude = $longitude;
			$this->latitude = $latitude;
			if($this->getUser()){
				$status = new Statuses($this->user, $message, $latitude, $longitude);
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