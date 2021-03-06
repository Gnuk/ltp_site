<?php
/*
*
* Copyright (c) 2012 GNKW
*
* This file is part of GNK Website.
*
* GNK Website is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* GNK Website is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with GNK Website.  If not, see <http://www.gnu.org/licenses/>.
*/
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
	private static $pagePath = null;
	private static $defaultPage = 'home';
	private static $rights = true;
	private static $rightUser = null;
	private static $method = 'rewrite';
	private static $getName = 'p';
	private static $js = array();
	private static $css = array();
	private static $sourceJs = array();
	private static $pageParams = array();
	private static $defaultExt = 'html';
	
	public static function setDefaultPage($page){
		self::$defaultPage = $page;
	}
	
	public static function setMethod($method){
		self::$method = $method;
	}
	
	public static function getMethod(){
		return self::$method;
	}
	
	public static function setGetName($getName){
		self::$getName = $getName;
	}
	
	/**
	* Retourne les paramètres de la page
	* @param boolean $all Retourne aussi le nom de la page en premier paramètre et l'extension par défaut en dernier paramètre si vrai
	*/
	public static function getParams($all = false){
		if(count(self::$pageParams)>0){
			if($all){
				return self::$pageParams;
			}
			else{
				$array=self::$pageParams;
				$last = count($array)-1;
				if(isset($array[$last]) AND $last != 0 AND $array[$last] == self::$defaultExt){
					unset($array[$last]);
				}
				if(isset($array[0])){
					unset($array[0]);
				}
				return array_values($array);
			}
		}
	}
	
	/**
	* Affichage de la page demandée (La page est de la forme <page>.page.php, fonctionne aussi en récursif avec le séparateur ':' et <repertoire>_DIR)
	* @param string $getName Le paramètre GET à viser
	* @param string $defaultPage La page par défaut
	*/
	public static function show($getName = null, $defaultPage = null){
		if(isset($getName)){
			self::$getName=$getName;
		}
		if(isset($defaultPage)){
			self::$defaultPage = $defaultPage;
		}
		self::$page = $defaultPage;
		self::$pagePath = $defaultPage;
		if((isset($_SERVER["PATH_INFO"]) AND is_file(self::getRewriteChemin($_SERVER["PATH_INFO"])))){
			self::$page = self::toPageLink($_SERVER["PATH_INFO"]);
			require_once(self::getChemin(self::$page));
		}
		else if(isset($_GET[self::$getName]) AND is_file(self::getChemin($_GET[self::$getName]))){
			self::$page = $_GET[self::$getName];
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
		$lastElem = count($explodePageName)-1;
		$pageInfos = $explodePageName[$lastElem];
		self::$pageParams = explode('.', $pageInfos);
		$explodePageName[$lastElem] = self::$pageParams[0];
		self::$pagePath = implode(':', $explodePageName);
		$implodePageName = implode('_DIR/', $explodePageName);
		return LINK_PAGES . $implodePageName . '.page.php';
	}
	
	public static function getParameterPage(){
		return self::$getName;
	}
	
	public static function getPagePath($all=true){
		if($all){
			return self::$page;
		}
		else{
			return self::$pagePath;
		}
	}
	
	public static function createPageLink($path, $params=NULL, $ext=true, $extVal=NULL){
		if(isset($params) AND is_array($params) AND count($params)>0){
			$pageParams = implode('.', $params);
			$path .= '.'.$pageParams;
		}
		if(self::$method == 'get'){
			$link = self::getFilePath() . '?' . self::$getName . '=' . $path;
		}
		else{
			$link = self::getFilePath() . self::toRewriteLink($path);
		}
		if($ext AND isset($extVal)){
			$link .= '.'.$extVal;
		}
		else if($ext AND isset(self::$defaultExt)){
			$link .= '.'.self::$defaultExt;
		}
		return $link;
	}
	
	
	
	private static function getHere(){
		return self::createPageLink(self::$pagePath);
	}
	
	
	/**
	* Récupère le chemin à partir du nom de page passé en GET
	* @param string $pageName Le nom de la page
	* @return string Le lien vers la page correspondante
	*/
	private static function getRewriteChemin($pageName){
		$implodePageName = self::toPageLink($pageName);
		return self::getChemin($implodePageName);
	}
	
	
	/**
	* Récupère le chemin à partir du nom de page passé en GET
	* @param string $pageName Le nom de la page
	* @return string Le lien vers la page correspondante
	*/
	private static function toPageLink($pageName){
		$page = preg_replace('#^\/#', '', $pageName);
		$explodePageName = explode('/', $page);
		$implodePageName = implode(':', $explodePageName);
		return $implodePageName;
	}
	
	
	
	private static function toRewriteLink($pagePath){
		return '/'.preg_replace('#\:#', '/', $pagePath);
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
		$r = self::getRights();
		if(self::goodRight($need, $r)){
			$right = true;
		}
		else{
			$right = false;
		}
		self::$rights = $right;
		return $right;
	}
	
	/**
	* Récupération des droits de l'utilisateur
	* @todo Récupérer les droits grâce aux infos en session et à la base de donnée (non implémenté)
	* @return char|int $right Le droit extrait de la base de donnée
	*/
	public static function getRights(){
		$right = 1;
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
	
	public static function paramsLink($params=NULL){
		if(isset($params)){
			return self::createPageLink(self::$pagePath, $params);
		}
		else{
			return self::createPageLink(self::$pagePath);
		}
	}
	
	/**
	 * Retourne le lien à partir des paramètres passés dans le tableau
	 * @param array $params
	 * @param boolean $here
	 * @param boolean $encode (Affiche &amp; si true)
	 */
	public static function getLink($params=null, $here=true, $encode = true){
		$getStarted = false;
		if($encode){
			$enc = '&amp;';
		}
		else{
			$enc = '&';
		}
		$array = array();
		$compose = array();
		if($here){
			$link = self::getHere();
			if(self::$method == 'get'){
				$getStarted = true;
			}
		}
		else{
			$link = self::getFilePath();
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
			if($getStarted){
				return $link . $enc .implode($enc, $compose);
			}
			else{
				return $link . '?'.implode($enc, $compose);
			}
		}
		else{
			return $link;
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
<script type="text/javascript" src="<?php echo self::rewriteLink($script);?>"></script>
<?php
			}
		}
		if(count(self::$sourceJs) > 0){
			foreach(self::$sourceJs as $nSourceJs => $source){
?>
<script type="text/javascript"><?php echo $source;?></script>
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
	* @param string $string Le lien ou le code
	* @param boolean $source Indique si le code est du code source
	*/
	public static function addJS($string, $source = false){
		if($source){
			self::$sourceJs[] = $string;
		}
		else{
			$js = self::$js;
			$js[] = $string;
			self::$js = array_unique($js);
		}
	}
	
	/**
	* Affiche les fichiers CSS à utiliser
	*/
	public static function showCSS(){
		if(count(self::$css) > 0){
			foreach(self::$css as $nCss => $style){
?>
<link rel="stylesheet" href="<?php echo self::rewriteLink($style);?>" type="text/css" media="screen">
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
	
	public static function defaultPageLink(){
		return self::createPageLink(self::$defaultPage);
	}
		
	/**
	* Encode du texte pour qu'il puisse passer sans erreurs dans du HTML
	* @param string $text Le texte
	* @return string Le texte encodé
	*/
	public static function htmlEncode($text){
		return htmlspecialchars($text, ENT_QUOTES);
	}
	
	public static function htmlBREncode($text){
		return nl2br(self::htmlEncode($text));
	}
	
	public static function textToOneLine($text){
		return $text = str_replace(array("\r", "\n","\r\n" ), '', $text);
	}
	
	public static function slashEncode($text){
		return addslashes($text);
	}
	
	public static function setHTTPCode($code)
	{
		http_response_code($code);
		return http_response_code();
	}
	
	public static function rewriteLink($link){
		return self::getFilePath() . '/../' . $link;
	}
	
	public static function getUrlImage($name, $size = 16){
		if(is_file(LINK_IMAGES . $size . '/' . $name)){
			return self::rewriteLink(LINKR_IMAGES . $size . '/' . $name);
		}
		else{
			return '';
		}
	}
	
	public static function getImage($name, $text, $size = 16){
		return '<img src="'.self::getUrlImage($name.'.png', $size).'" alt="'.Page::htmlEncode($text).'" />';
	}
	
	
	private static function getFilePath(){
		if(isset($_SERVER['PATH_INFO'])){
			$url_rewrite = preg_replace('#'.$_SERVER['PATH_INFO'].'$#', '', $_SERVER['PHP_SELF']);
		}
		else{
			$url_rewrite = $_SERVER['PHP_SELF'];
		}
		return $url_rewrite;
	}
	
	public static function getArrayPathInfo(){
		$pathArray = array();
		if(isset($_SERVER['PATH_INFO'])){
			$path = preg_replace('#^\/#', '', $_SERVER['PATH_INFO']);
			$path = preg_replace('#\/$#', '',$path);
			$pathArray = explode('/', $path);
		}
		return $pathArray;
	}
	
	public static function displayErrors($errors){
		$onlyone = false;
		if(is_array($errors)){
			if(count($errors)>1){
?>
<ul class="form_error">
<?php
				foreach($errors AS $nError => $error){
?>
	<li><?php echo self::htmlEncode($error);?></li>
<?php
				}
?>
</ul>
<?php
			}
			else if(count($errors) == 1){
				$onlyone = true;
				$oneerror = $errors[0];
			}
		}
		else{
			$onlyone = true;
			$oneerror = $errors;
		}
		if($onlyone){
?>
<p class="form_error">
	<?php echo self::htmlEncode($oneerror);?>
</p>
<?php
		}
	}
}
?>