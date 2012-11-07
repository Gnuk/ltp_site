<?php
	use \gnk\config\Database;
	use \gnk\config\Page;
	use \gnk\database\entities\Users;
	use \gnk\database\entities\Status;
	function getStatus($login, $password){
		Database::useTables();
		$qb = Database::getEM()->createQueryBuilder();
		$qb->select(array('s.longitude', 's.latitude', 's.message', 's.date', 'u.login'))
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
	
	if(isset($_POST['login']) AND isset($_POST['password'])){
		$login = $_POST['login'];
		$password = $_POST['password'];
	}
	else if(isset($_SERVER['PHP_AUTH_USER']) AND isset($_SERVER['PHP_AUTH_PW'])){
		$login = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];
	}
	if(isset($login) AND isset($password)){
?>
{"gpx":
  {"@version":"1.1",
    "@creator":"LocalizeTeaPot server",
    "wpt":
   [
<?php
		$status = getStatus($login, $password);
		foreach($status AS $nStat => $stat){
			if($nStat>0){
?>
	,
<?php
			}
?>
	{
		"@lat" : "<?php echo Page::htmlEncode($stat['latitude']) ;?>",
		"@lon" : "<?php echo Page::htmlEncode($stat['longitude']) ;?>",
		"name" : "<?php echo Page::htmlEncode($stat['login']) ;?>",
		"desc" : "<?php echo Page::htmlEncode($stat['message']) ;?>",
		"time":"<?php echo Page::htmlEncode($stat['date']->format('Y-m-d\TH:i:sP')) ;?>"
	}
<?php
		}
?>
   ]
  }
}
<?php
	}
	else{
	?>
Vous n'avez pas précisé de login ou/et de mot de passe.
<?php
	}
?>