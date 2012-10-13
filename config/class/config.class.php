<?php
namespace gnk;

# Utilisation de Setup et EntityManager pour Doctrine
use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;
/**
* Gère la configuration du site
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 06/10/2012
* @namespace gnk
*/
class Config{

	private static $defaultLocale;
	private static $encoding;
	private static $localedomain;
	private static $locale;
	private static $debug;
	
	/**
	* Génère la configuration
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
	}
	
	/**
	* Définit le langage de l'utilisateur
	*/
	private static function getLanguage($lang=null){
		$locale = self::$defaultLocale;
		$clientLocale = self::getLanguageFromClient();
		if(isset($lang) AND isset($_GET[$lang])){
			$clientLocale = $_GET[$lang];
		}
		if(is_file(LINK_LOCALE . $clientLocale . '/LC_MESSAGES/' . self::$localedomain . '.mo')){
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
	private static function putSessions($user='anonymous', $rights = 0, $id=null){
		$_SESSION['user'] = $user;
		$_SESSION['rights'] = $rights;
		if(isset($id)){
			$_SESSION['user_id'] = $id;
		}
	}
	
	/**
	* Récupère les droits de l'utilisateur courant
	* @return int
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
		return false;
	}
	
	/**
	* Vérification de l'utilisateur
	*/
	private static function connect(){
		self::putSessions();
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
	public static function setDatabase(){
		$doctrineDir = LINK_LIB . 'doctrine';
		if(is_dir($doctrineDir)){
			if(is_file($doctrineDir.'/Doctrine/ORM/Tools/Setup.php')){
				require_once($doctrineDir.'/Doctrine/ORM/Tools/Setup.php');
				self::$debug->add(sprintf(T_('Fichier %s chargé'), $doctrineDir.'/Doctrine/ORM/Tools/Setup.php'));
				$lib = $doctrineDir;
				Setup::registerAutoloadDirectory($lib);
			}
			else{
				self::$debug->addWarning(sprintf(T_('Le fichier "%s" est absent, peut-être que Doctrine n\'est pas installé'), $doctrineDir));
			}
		}
		else{
			self::$debug->addWarning(sprintf(T_('La bibliothèque Doctrine "%s" est absente'), $doctrineDir));
		}
	}
}
?>