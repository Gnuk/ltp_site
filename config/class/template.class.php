<?php
	namespace gnk\config;
	/**
	* Gestion des templates
	* @author Anthony REY <anthony.rey@mailoo.org>
	*/
	class Template{
		private static $defaultTemplate;
		private $template;
		private $link;
		private $websiteConfig = array();
		
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
			$this->getWebsiteParams();
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
		public static function setDefaultTemplate($defaultTemplate){
			self::$defaultTemplate = $defaultTemplate;
		}
		
		/**
		* Récupère les paramètres utilisateur pour la page
		*/
		private function getWebsiteParams(){
			$configFile = LINK_USERCONFIG . 'website.conf.php';
			if(count($global = Config::getWebsiteConfig())>0){
				$config = array();
				if(isset($global['title'])){
					$config['title'] = $global['title'];
				}
				
				$config = array_merge($config, Config::getConfigFile($configFile));
				$this->websiteConfig = array_unique($config, SORT_REGULAR);
			}
			else{
				$this->websiteConfig = Config::getConfigFile($configFile);
			}
			
		}
		
		/**
		* Affiche les paramètres du site (balises meta, title)
		*/
		public function showWebsiteParams(){
			foreach($this->websiteConfig AS $nConfig => $config){
				if($nConfig == 'title'){
?>
		<title><?php echo Page::htmlEncode($config);?></title>
<?php
				}
				else{
					if(is_array($config)){
?>
		<meta name="<?php echo Page::htmlEncode($nConfig);?>" content="<?php
			echo Page::htmlEncode(implode(', ', $config));
		?>" />
<?php
					}
					else{
?>
		<meta name="<?php echo Page::htmlEncode($nConfig);?>" content="<?php echo Page::htmlEncode($config);?>" />
<?php
					}
				}
			}
		}
		
		/**
		* Ajoute un titre à la page, peut être utilisé plusieurs fois
		* @param string $title Le titre
		*/
		public function addTitle($title){
			if(isset($this->websiteConfig['title'])){
				$this->websiteConfig['title'] .= ' - ' . $title;
			}
			else{
				$this->websiteConfig['title'] = $title;
			}
		}
		
		/**
		* Change la description de la page
		* @param string $description La description
		*/
		public function setDescription($description){
			$this->websiteConfig['description'] = $description;
		}
		
		/**
		* Change l'auteur de la page
		* @param string $author L'auteur
		*/
		public function setAuthor($author){
			$this->websiteConfig['author'] = $author;
		}
		
		/**
		* Ajoute des mots clés à la page, peut être utilisé plusieurs fois
		* @param array $keywords Le tableau de mots clés
		*/
		public function addKeywords($keywords){
			$keywordsNotUni = array_merge($this->websiteConfig['keywords'], $keywords);
			$this->websiteConfig['keywords'] = array_unique($keywordsNotUni, SORT_REGULAR);
		}
	}
?>