<?php
/**
* Gère la configuration du site
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 06/10/2012
*/
class Config{

	private static $defaultLocale;
	private static $encoding;
	private static $localedomain;
	private static $locale;
	
	/**
	* Génère la configuration
	*/
	public static function setConfig(){
		self::$encoding = 'UTF-8';
		self::$defaultLocale='en_US';
		self::$localedomain='messages';
		self::$locale=self::$defaultLocale;
		self::setLocales();
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
	}
}
?>