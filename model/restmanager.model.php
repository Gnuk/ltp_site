<?php
namespace gnk\model;

use \gnk\config\Model;

class RestManager extends Model{
		
	/**
	* Constructeur
	*/
	public function __construct(){
		parent::__construct();
	}
	
	function getUserProfile($login, $password){
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('u.id', 'u.login', 'u.language', 'u.mail'))
			->from('\gnk\database\entities\Users', 'u')
			->where('u.login LIKE ?1')
			->andWhere('u.password LIKE ?2');
		$qb->setParameters(array(1 => $login, 2 => sha1($password)));
		$query = $qb->getQuery();
		$result = $query->getResult();
		return $result;
	}
	
	function getStatuses($login, $password){
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('s.longitude', 's.latitude', 's.message', 's.date'))
			->from('\gnk\database\entities\Status', 's')
			->leftJoin('\gnk\database\entities\Users', 'u', 'WITH', 's.user = u.id')
			->where('u.login LIKE ?1')
			->andWhere('u.password LIKE ?2')
			->orderBy('s.date', 'DESC');
		$qb->setParameters(array(1 => $login, 2 => sha1($password)));
		$query = $qb->getQuery();
		$result = $query->getResult();
		return $result;
	}
}
?>