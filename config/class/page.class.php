<?php
namespace gnk\config;
use \gnk\database\entities\Users;
/**
* Gestion des pages
* @author Anthony REY <gnuk@mailoo.org>
* @since 05/10/2012
* @namespace gnk\config
*/
class Page{
	
	private static $page = null;
	private static $defaultPage = null;
	private static $rights = true;
	private static $rightUser = null;
	
	/**
	* Affichage de la page demandée (La page est de la forme <page>.page.php, fonctionne aussi en récursif avec le séparateur ':' et <repertoire>_DIR)
	* @param string $getName Le paramètre GET à viser
	* @param string $defaultPage La page par défaut
	*/
	public static function show($getName = 'p', $defaultPage = 'home'){
		self::$defaultPage = $defaultPage;
		self::$page = $defaultPage;
		if(isset($_GET[$getName]) AND is_file(self::getChemin($_GET[$getName]))){
			self::$page = $_GET[$getName];
			require_once(self::getChemin(self::$page));
		}
		else{
			self::showDefault();
		}
	}
	
	/**
	* Récupère le chemin à partir du nom de page passé en GET
	* @param string $pageName Le nom de la page
	* @return string Le lien vers la page correspondante
	*/
	private static function getChemin($pageName){
		$explodePageName = explode(':', $pageName);
		$implodePageName = implode('_DIR/', $explodePageName);
		return LINK_PAGES . $implodePageName . '.page.php';
	}
	
	/**
	* Affiche la page par défaut si elle existe
	*/
	public static function showDefault(){
		if(is_file(self::getChemin(self::$defaultPage)) AND self::$rights){
			self::$page = self::$defaultPage;
			require_once(self::getChemin(self::$defaultPage));
		}
		else if(is_file(LINK_ERROR404)){
			require_once(LINK_ERROR404);
		}
		else{
?><html>
<head>
	<meta charset="UTF-8" />
	<title><?php echo T_('Erreur 404') ?></title>
</head>
<body>
	<h1><?php echo T_('Erreur 404') ?></h1>
	<p>
		<?php echo T_('Veuillez créer une page error404.html à la racine'); ?>
	</p>
</body>
</html><?php
		}
	}
	
	/**
	* Indique si l'utilisateur a le droit d'accéder à la page
	* @param int $need Les droits nécessaires
	* @param int $others Les droits des autres (visiteurs par exemple ou lorsque ce n'est pas implémenté en base de donnée)
	* @return boolean $right Si les droits sont nécessaires ou non
	*/
	public static function haveRights($need=1, $others=1){
		$right=false;
		if(($r = self::getRights()) != '?'){
			if(self::goodRight($need, $r)){
				$right = true;
			}
			else{
				$right = false;
			}
		}
		else if(self::goodRight($need, $others)){
			$right = true;
		}
		self::$rights = $right;
		return $right;
	}
	
	/**
	* Récupération des droits de l'utilisateur
	* @todo Récupérer les droits grâce aux infos en session et à la base de donnée (non implémenté)
	* @return char|int $right Le droit extrait de la base de donnée
	*/
	private static function getRights(){
		$right = '?';
		if(!isset(self::$rightUser)  AND Config::isUser()){
			Database::useTables();
			$em = Database::getEM();
			$qb = $em->createQueryBuilder();
			$qb->select('u.rights')
				->from('\gnk\database\entities\Users', 'u')
				->where('u.id = ?1')
				->andWhere('u.active = ?2');
			$qb->setParameters(array(1 => $_SESSION['user_id'], 2 => true));
			$query = $qb->getQuery();
			$result = $query->getResult();
			if(isset($result[0]['rights'])){
				$right = $result[0]['rights'];
			}
		}
		else if(isset(self::$rightUser)){
			$right = self::$rightUser;
		}
		self::$rightUser = $right;
		return $right;
	}
	
	/**
	* Vérifie si les droits permettent d'accéder à une ressource ou non
	* @param int $need Le droit nécessaire à l'affichage de la ressource
	* @param int $right Le droit qui est envoyé
	* @return boolean $good Si vous avez ou non les droits
	*/
	private static function goodRight($need, $right){
		if($right >= $need){
			return true;
		}
		else{
			return false;
		}
	}
}
?>