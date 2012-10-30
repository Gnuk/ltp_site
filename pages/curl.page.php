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
	if(isset($_SERVER['PHP_AUTH_USER']) AND isset($_SERVER['PHP_AUTH_PW'])){
?>
<?xml version='1.0' encoding='UTF-8'?>
<gpx version="1.1" creator="LocalizeTeaPot server" xmlns="http://www.topografix.com/GPX/1/1"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd">
<?php
		$status = getStatus($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
		foreach($status AS $nStat => $stat){
?>
	<wpt lat="<?php echo Page::htmlEncode($stat['latitude']) ;?>" lon="<?php echo Page::htmlEncode($stat['longitude']) ;?>">
		<name><?php echo Page::htmlEncode($stat['login']) ;?></name>
		<desc><?php echo Page::htmlEncode($stat['message']) ;?></desc>
		<time><?php echo Page::htmlEncode($stat['date']->format('Y-m-d\TH:i:sP')) ;?></time>
	</wpt>
<?php
		}
?>
</gpx>
<?php
	}
	else{
	?>
Vous n'avez pas précisé de login ou/et de mot de passe.
<?php
	}
?>