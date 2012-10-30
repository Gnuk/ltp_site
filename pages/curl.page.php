<?php
	use \gnk\config\Database;
	use \gnk\config\Page;
	use \gnk\database\entities\Users;
	use \gnk\database\entities\Status;

	function getStatus($login, $password){
		Database::useTables();
		$qb = Database::getEM()->createQueryBuilder();
		$qb->select(array('s'))
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
	if(isset($_SERVER['PHP_AUTH_USER']) AND isset($_SERVER['PHP_AUTH_PW'])){
		$status = getStatus($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
		foreach($status AS $nStat => $stat){
?>
	<ul>
		<li>Longitude : <?php echo $stat->getLongitude() ;?></li>
		<li>Latitude : <?php echo $stat->getLatitude() ;?></li>
		<li>Message : <?php echo $stat->getMessage() ;?></li>
	</ul>
<?php
		}
	}
	else{
	?>
Vous n'avez pas précisé de login ou/et de mot de passe.
<?php
	}
?>