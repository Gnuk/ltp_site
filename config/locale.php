<?php
	/*
	# Define constants
	define('DEFAULT_LOCALE', 'fr_FR');
	define('DEFAULT_ENCODING', 'UTF-8');
	define('DEFAULT_LOCALEDOMAIN', 'messages');

	require_once(LINK_LIB . 'gettext/gettext.inc');

	$supported_locales = array('en_US', 'fr_FR');

	$LOCALE = (isset($_GET['lang']))? $_GET['lang'] : DEFAULT_LOCALE;
	
	# Déclaration de gettext 
	T_setlocale(LC_MESSAGES, $LOCALE);
	T_bindtextdomain(DEFAULT_LOCALEDOMAIN, LINK_LOCALE);
	T_bind_textdomain_codeset(DEFAULT_LOCALEDOMAIN, DEFAULT_ENCODING);
	T_textdomain(DEFAULT_LOCALEDOMAIN);

	header("Content-type: text/html; charset=" . DEFAULT_ENCODING);*/
		// define constants
	define('PROJECT_DIR', realpath('./'));
	define('LOCALE_DIR', PROJECT_DIR .'/locale');
	define('DEFAULT_LOCALE', 'fr_FR');

	require_once(PROJECT_DIR . '/lib/gettext/gettext.inc');

	$supported_locales = array('en_US', 'fr_FR');
	$encoding = 'UTF-8';

	$locale = (isset($_GET['lang']))? $_GET['lang'] : DEFAULT_LOCALE;

	// gettext setup
	T_setlocale(LC_MESSAGES, $locale);
	// Set the text domain as 'messages'
	$domain = 'messages';
	T_bindtextdomain($domain, LOCALE_DIR);
	T_bind_textdomain_codeset($domain, $encoding);
	T_textdomain($domain);

	header("Content-type: text/html; charset=$encoding");
?>