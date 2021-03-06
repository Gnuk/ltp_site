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

# Utilisation de Setup et EntityManager pour Doctrine
use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;
use \Symfony\Component\Console\Helper\HelperSet;
use \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use \Doctrine\ORM\Tools\Console\ConsoleRunner;
use \gnk\database\entities\Users;
/**
* Gère la configuration du site
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 06/10/2012
* @namespace gnk\config
*/
class Config{

	private static $defaultLocale;
	private static $encoding;
	private static $localedomain;
	private static $locale;
	private static $debug;
	private static $info;
	private static $license;
	private static $contentLicense;
	private static $year = '2012';
	protected static $em = null;
	private static $dbConfig = false;
	private static $websiteConfig = array();
	
	/**
	* Génère la configuration
	*/
	public static function setConfig(){
		require_once(LINK_LIB . 'gettext/gettext.inc');
		require_once(LINK_CONFIG . 'include/functionNotSupported.php');
		self::$debug = new Debug(true);
		self::$encoding = 'UTF-8';
		self::$defaultLocale='en';
		self::$localedomain='messages';
		self::$locale=self::$defaultLocale;
		self::$license['name'] = 'AGPL v3';
		self::$license['url'] = 'http://www.gnu.org/licenses/agpl-3.0.html';
		self::$contentLicense['name'] = 'Creative Commons BY SA 3.0';
		self::$contentLicense['url'] = 'http://creativecommons.org/licenses/by-sa/3.0/';
		self::setWebsiteConfig();
		self::setDatabase();
		self::setSessions();
		self::setLocales();
		self::setTemplate();
		self::setMail();
		self::setPageConfig();
	}
	
	private static function setPageConfig(){
		if(isset(self::$websiteConfig['pageDefault'])){
			Page::setDefaultPage(self::$websiteConfig['pageDefault']);
		}
		if(isset(self::$websiteConfig['pageMethod'])){
			Page::setMethod(self::$websiteConfig['pageMethod']);
		}
		if(isset(self::$websiteConfig['pageGetName'])){
			Page::setGetName(self::$websiteConfig['pageGetName']);
		}
	}
	
	/**
	* Instancie le template
	*/
	private static function setTemplate(){
		$defaultTheme = 'default';
		if(isset(self::$websiteConfig['theme'])){
			$defaultTheme = self::$websiteConfig['theme'];
		}
		Template::setDefaultTemplate($defaultTheme);
	}
	
	/**
	* Instancie les mails
	*/
	private static function setMail(){
		$defaultUser = 'admin';
		$defaultMail = 'admin@yourserver.org';
		if(isset(self::$websiteConfig['user'])){
			$defaultUser = self::$websiteConfig['user'];
		}
		if(isset(self::$websiteConfig['mail'])){
			$defaultMail = self::$websiteConfig['mail'];
		}
		Tools::setMailDefaultSender($defaultUser,  $defaultMail);
	}
	
	/**
	* Créé la configuration globale du site
	*/
	private static function setWebsiteConfig(){
		$configFile = LINK_USERCONFIG . 'global.conf.php';
		self::$websiteConfig = self::getConfigFile($configFile);
		if(isset(self::$websiteConfig['year'])){
			self::$year = self::$websiteConfig['year'];
		}
		if(isset(self::$websiteConfig['license'])){
			self::$license = self::$websiteConfig['license'];
		}
	}
	
	/**
	* Récupère la ou les années d'activité du site
	* @return string La ou les années
	*/
	public static function getYear(){
		return self::$year;
	}
	
	/**
	* Récupère la licence du site
	* @return string La licence
	*/
	public static function getLicense(){
		return self::$license;
	}
	
	/**
	* Récupère la licence du site
	* @return string La licence
	*/
	public static function getContentLicense(){
		return self::$contentLicense;
	}
	
	/**
	* Récupère la configuration globale du site
	* @return array $websiteConfig
	*/
	public static function getWebsiteConfig(){
		return self::$websiteConfig;
	}
	
	/**
	* Définit le langage de l'utilisateur
	*/
	private static function getLanguage($lang=null){
		if(isset(self::$websiteConfig['locale'])){
			$locale = self::$websiteConfig['locale'];
		}
		else{
			$locale = self::$defaultLocale;
		}
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
			$clientLocale = self::getLanguageFromClient();
		}
		if(isset($_SESSION['user_lang'])){
			$clientLocale = $_SESSION['user_lang'];
		}
		if(isset($lang) AND isset($_GET[$lang])){
			$clientLocale = $_GET[$lang];
		}
		if(isset($clientLocale)){
			$clientLang = self::getLangFromLocale($clientLocale);
			if(is_file(LINK_LOCALE . $clientLocale . '/LC_MESSAGES/' . self::$localedomain . '.mo')){
				$locale=$clientLocale;
			}
			else if(is_file(LINK_LOCALE . $clientLang . '/LC_MESSAGES/' . self::$localedomain . '.mo')){
				$locale=$clientLang;
			}
		}
		self::$locale=$locale;
	}
	
	/**
	* Affiche la Locale de votre langue
	*/
	public static function showLocale(){
		echo self::getLanguageFromClient();
	}
	
	/**
	* Récupère le langage du navigateur
	* @return Le langage au format des LOCALES (voir librairie gettext)
	*/
	private static function getLanguageFromClient(){
		$language_info = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$lang = explode('-',$language_info[0]);
		$locale = implode('_', $lang);
		return $locale;
	}
	
	private static function getLangFromLocale($clientLocale){
		$client = explode('_',$clientLocale);
		return $client[0];
	}
	
	/**
	* Définit les LOCALES pour le site
	*/
	private static function setLocales(){

		self::getLanguage('lang');
		
		# Déclaration de gettext 
		T_setlocale(LC_MESSAGES, self::$locale);
		T_bindtextdomain(self::$localedomain, LINK_LOCALE);
		T_bind_textdomain_codeset(self::$localedomain, self::$encoding);
		T_textdomain(self::$localedomain);

		header('Content-type: text/html; charset=' . self::$encoding);
		self::$debug->add(T_('Locales initialisées'));
	}
	
	/**
	* Récupère la session et l'initialise
	* @param string $connection
	* @param string $deconnection
	*/
	private static function setSessions($connection = 'connection', $disconnection = 'disconnection'){
		if(isset($_GET[$disconnection])){
			self::$debug->add(T_('Déconnexion'));
			self::disconnect();
		}
		session_start();
		if(isset($_GET[$connection]) AND isset($_POST['login']) AND isset($_POST['password'])){
			self::$debug->add(T_('Tentative de connexion'));
			self::connect();
		}
		else if(empty($_SESSION)){
			self::$debug->add(T_('Anonymous'));
			self::putSessions();
		}
	}
	
	/**
	* Définit les sessions
	* @param string $user Nom de l'utilisateur
	* @param int $rights Droits de l'utilisateur
	* @param int $id Identifiant utilisateur
	*/
	private static function putSessions($user='anonymous', $id=null, $language=null){
		$_SESSION['user'] = $user;
		if(isset($id)){
			$_SESSION['user_id'] = $id;
		}
		if(isset($language)){
			$_SESSION['user_lang'] = $language;
		}
	}
	
	/**
	* Indique si un utilisateur est connecté ou non
	* @return boolean
	*/
	public static function isUser(){
		if(isset($_SESSION['user_id'])){
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	* Vérification de l'utilisateur
	*/
	private static function connect(){
		Database::useTables();
		$em=Database::getEM();
		$qb = $em->createQueryBuilder();
		$qb->select('u')
			->from('\gnk\database\entities\Users', 'u')
			->where('u.login = ?1')
			->andWhere('u.password = ?2');
		$qb->setParameters(array(1 => $_POST['login'], 2 => sha1($_POST['password'])));
		$query = $qb->getQuery();
		$result = $query->getResult();
		if(count($result) > 0 AND $result[0]->getActive()){
			$user = $result[0];
			self::putSessions($user->getLogin(), $user->getId(), $user->getLanguage());
		}
		else{
			self::$info[]=T_('Votre identifiant ou/et votre mot de passe est erroné');
			self::putSessions();
		}
	}
	
	public static function getInfo(){
		return self::$info;
	}
	
	/**
	* Déconnexion
	*/
	private static function disconnect(){
		session_start();
		$_SESSION = array();
		session_destroy();
	}
	
	/**
	* Connecte la base de donnée
	*/
	private static function setDatabase(){
		$doctrineDir = LINK_LIB . 'doctrine';
		if(is_dir($doctrineDir)){
			if(is_file($doctrineDir.'/Doctrine/ORM/Tools/Setup.php')){
				require_once(LINK_CONFIG.'include/doctrineConnect.php');
				self::$debug->add(sprintf(T_('Fichier %s chargé'), $doctrineDir.'/Doctrine/ORM/Tools/Setup.php'));
				self::$em = EntityManager::create($conn, $config);
			}
			else{
				self::$debug->addWarning(sprintf(T_('Le fichier "%s" est absent, peut-être que Doctrine n\'est pas installé'), $doctrineDir));
			}
		}
		else{
			self::$debug->addWarning(sprintf(T_('La bibliothèque Doctrine "%s" est absente'), $doctrineDir));
		}
	}
	
	/**
	* Récupère une configuration depuis un fichier texte
	*/
	public static function getConfigTextFile($link){
		$dataTable = array();
		if(is_file($link)){
			$file = file($link);
			foreach($file as $nbLine => $expression){
				if(preg_match("#^(\w)+(\ =|=)(.+)#", $expression)){
					$param = trim(preg_replace("#^(.+)=(.+)#","$1",  $expression));
					$data = trim(preg_replace("#^(.+)=(.+)#","$2",  $expression));
					$dataTable[$param] = $data;
				}
			}
		}
		return $dataTable;
	}
	
	/**
	* Récupère une configuration depuis un fichier de configuration
	*/
	public static function getConfigFile($link){
		$dataTable = array();
		if(is_file($link)){
			require($link);
			if(isset($params)){
				$dataTable = $params;
			}
		}
		return $dataTable;
	}
	
	/**
	* Setter de $dbConfig
	* @param boolean $dbConfig
	*/
	public static function setDbConfig($dbConfig){
		self::$dbConfig = $dbConfig;
	}
	
	/**
	* Indique si la configuration de la base de donnée a été définie
	* @return boolean
	*/
	public static function getDbConfig(){
		return self:: $dbConfig;
	}
	
	
		
	/**
	* Récupère la liste des langages indexés par le langage
	*/
	public static function getLanguages(){
		$lang = array();
		if ($handle = opendir(LINK_LOCALE)) {
			/* Ceci est la façon correcte de traverser un dossier. */
			while (false !== ($entry = readdir($handle))) {
				if(is_file(LINK_LOCALE .$entry. '/LC_MESSAGES/' . self::$localedomain . '.mo')){
					$lang[$entry]=$entry;
				}
			}
			closedir($handle);
		}
		return $lang;
	}
	
	/**
	* Récupère l'ID de l'utilisateur, envoie 0 s'il n'y en a pas
	* @return int
	*/
	public static function getUserId(){
		if(isset($_SESSION['user_id'])){
			return $_SESSION['user_id'];
		}
		else{
			return 0;
		}
	}
}

require_once(LINK_CONFIG.'class/config/database.class.php');
?>