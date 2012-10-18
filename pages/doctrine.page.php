<?php
	use \gnk\config\Config;
	use \gnk\config\Database;
	use \gnk\database\entities\Users;
	Database::useTables();
	$em = Database::getEM();
	
	function isUser($username, $mail){
		$em = Database::getEM();
		$qb = $em->createQueryBuilder();
		$qb->select($qb->expr()->count('u.id'))
			->from('\gnk\database\entities\Users', 'u')
			->where($qb->expr()->orX(
				$qb->expr()->like('u.login', '?1'),
				$qb->expr()->like('u.mail', '?2')
			));
		$qb->setParameters(array(1 => $username, 2 => $mail));
		$query = $qb->getQuery();
		$result = $query->getSingleResult();
		if($result[1] > 0){
			return true;
		}
		return false;
	}
	
	function addUser($username, $password, $mail){
		if(!isUser($username, $mail)){
			$user=new Users($username, $password, $mail);
			$em = Database::getEM();
			$em->persist($user);
			$em->flush();
			echo T_('Utilisateur ajouté');
		}
		else{
			echo T_('Un utilisateur porte déjà ce login ou ce mail');
		}
	}
	
	addUser('Giu', 'monpassword', 'giu@seppe.cin');
?>