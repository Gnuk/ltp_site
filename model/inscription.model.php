<?php
	namespace gnk\model;
	use \gnk\config\Database;
	use \gnk\database\entities\Users;
	class Inscription{
		private $em;
		private $username;
		private $password;
		private $mail;
		public function __construct(){
			Database::useTables();
			$this->em = Database::getEM();
		}
		private function isUser(){
			$qb = $this->em->createQueryBuilder();
			$qb->select($qb->expr()->count('u.id'))
				->from('\gnk\database\entities\Users', 'u')
				->where($qb->expr()->orX(
					$qb->expr()->like('u.login', '?1'),
					$qb->expr()->like('u.mail', '?2')
				));
			$qb->setParameters(array(1 => $this->username, 2 => $this->mail));
			$query = $qb->getQuery();
			$result = $query->getSingleResult();
			if($result[1] > 0){
				return true;
			}
			return false;
		}
		
		public function addUser($username, $password, $mail){
			$this->username = $username;
			$this->password = $password;
			$this->mail=$mail;
			if(!$this->isUser()){
				$user=new Users($username, $password, $mail);
				$this->em->persist($user);
				$this->em->flush();
// 				echo T_('Utilisateur ajouté');
				return true;
			}
			else{
// 				echo T_('Un utilisateur porte déjà ce login ou ce mail');
				return false;
			}
		}
	}
?>