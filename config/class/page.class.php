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
	private static $getName = 'p';
	private static $js = array();
	private static $css = array();
	
	/**
	* Affichage de la page demandée (La page est de la forme <page>.page.php, fonctionne aussi en récursif avec le séparateur ':' et <repertoire>_DIR)
	* @param string $getName Le paramètre GET à viser
	* @param string $defaultPage La page par défaut
	*/
	public static function show($getName = 'p', $defaultPage = 'home'){
		self::$getName=$getName;
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
	
	/**
	 * Retourne le lien à partir des paramètres passés dans le tableau
	 * @param array $params
	 * @param boolean $here
	 * @param boolean $encode (Affiche &amp; si true)
	 */
	public static function getLink($params=null, $here=true, $encode = true){
		if($encode){
			$enc = '&amp;';
		}
		else{
			$enc = '&';
		}
		$array = array();
		$compose = array();
		if($here){
			if(isset($_GET['p'])){
				$array[self::$getName] = $_GET['p'];
			}
		}
		if(isset($params) AND is_array($params)){
			$array = array_merge($array,$params);
		}
		foreach ($array as $nParam => $param) {
			if(!isset($param) OR $param == ''){
				$compose[] = $nParam;
			}
			else{
				$compose[] = $nParam . '=' . $param;
			}
		}
		if(count($compose)>0){
			return '?'.implode($enc, $compose);
		}
		else{
			return '';
		}
	}
	
	/**
	* Récupère la liste des fichiers JS
	* @return array Les liens des fichiers
	*/
	public static function getJS(){
		return self::$js;
	}
	
	/**
	* Affiche les fichiers JS à utiliser
	*/
	public static function showJS(){
		if(count(self::$js) > 0){
			foreach(self::$js as $nJs => $script){
?>
<script type="text/javascript" src="<?php echo $script;?>"></script>
<?php
			}
		}
	}
	
	/**
	* Indique des liens de fichiers JS à ajouter
	* @param array $array Le tableau des liens
	*/
	public static function setJS($array){
		$js=array_merge(self::$js, $array);
		self::$js=array_unique($js);
	}
	
	/**
	* Ajoute un lien de fichier JS
	* @param string $string Le lien
	*/
	public static function addJS($string){
		$js = self::$js;
		$js[] = $string;
		self::$js = array_unique($js);
	}
	
	/**
	* Affiche les fichiers CSS à utiliser
	*/
	public static function showCSS(){
		if(count(self::$css) > 0){
			foreach(self::$css as $nCss => $style){
?>
<link rel="stylesheet" href="<?php echo $style;?>" type="text/css" media="screen">
<?php
			}
		}
	}
	
	/**
	* Indique des liens de fichiers CSS à ajouter
	* @param array $array Le tableau des liens
	*/
	public static function setCSS($array){
		$css=array_merge(self::$css, $array);
		self::$css=array_unique($css);
	}
	
	/**
	* Ajoute un lien de fichier CSS
	* @param string $string Le lien
	*/
	public static function addCSS($string){
		$css = self::$css;
		$css[] = $string;
		self::$css = array_unique($css);
	}
	
	/**
	* Récupère le nom de la page par défaut
	* @return string $defaultPage
	*/
	public static function getDefaultPage(){
		return self::$defaultPage;
	}
		
	/**
	* Encode du texte pour qu'il puisse passer sans erreurs dans du HTML
	* @param string $text Le texte
	* @return string Le texte encodé
	*/
	public static function htmlEncode($text){
		return htmlspecialchars($text, ENT_QUOTES);
	}
}
?>