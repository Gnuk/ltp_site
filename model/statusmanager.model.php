<?php
	namespace gnk\model;
	use \gnk\config\Database;
	use \gnk\config\Config;
	use \gnk\database\entities\Users;
	use \gnk\database\entities\Status;
	
	class StatusManager{
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
	}
?>