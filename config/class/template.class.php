<?php
	namespace gnk\config;
	/**
	* Gestion des templates
	* @author Anthony REY <anthony.rey@mailoo.org>
	*/
	class Template{
		private static $defaultTemplate = 'otm';
		private $template;
		private $link;
		
		/**
		* Constructeur du Template
		* @param string $template Le nom du template à utiliser
		*/
		public function __construct($template = null){
			if(isset($template) AND is_dir(LINK_TEMPLATE . $template)){
				$this->template = $template;
			}
			else{
				$this->template = self::$defaultTemplate;
			}
			$this->link = LINKR_TEMPLATE . $this->template . '/';
		}
		
		/**
		* Affiche la partie du template demandée
		* @param string $tmpl La partie à afficher
		*/
		public function show($tmpl){
			$link=LINK_TEMPLATE . $this->template . '/' .  $tmpl . '.tmpl.php';
			if(is_file($link)){
				require($link);
			}
		}
		
		/**
		* Récupère le lien relatif du template
		* @return string Le lien
		*/
		public function getLink(){
			return $this->link;
		}
		
		/**
		* Définit le template par défaut
		* @param string $defaultTemplate Le nom du template
		* @todo Appeller cette méthode via la configuration pour le thème choisit par l'utilisateur
		*/
		public function setDefaultTemplate($defaultTemplate){
			self::$defaultTemplate = $defaultTemplate;
		}
		
	}
?>