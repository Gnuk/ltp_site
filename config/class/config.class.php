<?php
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
	protected static $em = null;
	private static $dbConfig = false;
	
	/**
	* Génère la configuration
	* @todo Récupérer des configurations par défaut dans un fichier texte
	*/
	public static function setConfig(){
		self::$debug = new Debug(true);
		self::$encoding = 'UTF-8';
		self::$defaultLocale='en_US';
		self::$localedomain='messages';
		self::$locale=self::$defaultLocale;
		self::setLocales();
		self::setDatabase();
		self::setSessions();
		Template::setDefaultTemplate('otm');
		Tools::setMailDefaultSender('Anthony REY',  'gnuk.server@gmail.com');
	}
	
	/**
	* Définit le langage de l'utilisateur
	*/
	private static function getLanguage($lang=null){
		$locale = self::$defaultLocale;
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
			$clientLocale = self::getLanguageFromClient();
		}
		if(isset($lang) AND isset($_GET[$lang])){
			$clientLocale = $_GET[$lang];
		}
		if(isset($clientLocale) AND is_file(LINK_LOCALE . $clientLocale . '/LC_MESSAGES/' . self::$localedomain . '.mo')){
			$locale=$clientLocale;
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
	
	/**
	* Définit les LOCALES pour le site
	*/
	private static function setLocales(){
		require_once(LINK_LIB . 'gettext/gettext.inc');

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
	private static function putSessions($user='anonymous', $id=null){
		$_SESSION['user'] = $user;
		if(isset($id)){
			$_SESSION['user_id'] = $id;
		}
	}
	
	/**
	* Récupère les droits de l'utilisateur courant
	* @return int
	* @deprecated
	*/
	public static function getRights(){
		$rights = 0;
		if(isset($_SESSION['rights'])){
			$rights = $_SESSION['rights'];
		}
		return $rights;
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
			self::putSessions($user->getLogin(), $user->getId());
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
}

require_once(LINK_CONFIG.'class/config/database.class.php');
?>