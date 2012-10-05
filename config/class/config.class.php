<?php
class Config{
	private static function getLanguage(){
		$language_info = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$lang = explode('-',$language_info[0]);
		$locale = implode('_', $lang);
		return $locale;
	}
	
	public static function setLocales(){
		# Define constants
		define('DEFAULT_ENCODING', 'UTF-8');
		define('DEFAULT_LOCALEDOMAIN', 'messages');

		require_once(LINK_LIB . 'gettext/gettext.inc');

		$LOCALE = (isset($_GET['lang']))? $_GET['lang'] : self::getLanguage();
		
		# Déclaration de gettext 
		T_setlocale(LC_MESSAGES, $LOCALE);
		T_bindtextdomain(DEFAULT_LOCALEDOMAIN, LINK_LOCALE);
		T_bind_textdomain_codeset(DEFAULT_LOCALEDOMAIN, DEFAULT_ENCODING);
		T_textdomain(DEFAULT_LOCALEDOMAIN);

		header("Content-type: text/html; charset=" . DEFAULT_ENCODING);
	}
}
?>