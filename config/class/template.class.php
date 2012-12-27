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
	/**
	* Gestion des templates
	* @author Anthony REY <anthony.rey@mailoo.org>
	*/
	class Template{
		private static $defaultTemplate;
		private $template;
		private $link;
		private $websiteConfig = array();
		private $websiteValues = array();
		
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
			$this->menu = Config::getConfigFile(LINK_USERCONFIG . 'menu.conf.php');
			$this->rights = Page::getRights();
		}
		
		public function getWebsiteValue($val){
			return $this->websiteValues[$val];
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
		public function getLink($formated = true){
			if($formated){
				$link = Page::rewriteLink($this->link);
			}
			else{
				$link = $this->link;
			}
			return $link;
		}
		
		/**
		* Définit le template par défaut
		* @param string $defaultTemplate Le nom du template
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
			$this->websiteValues = Config::getConfigFile($configFile);
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
		
		public function showMenu(){
			if(is_array($this->menu) AND count($this->menu > 0)){
				$this->displayMenu($this->menu);
			}
		}
		
		private function displayMenu($menu, $link=array()){
			echo '<ul>'."\n";
			foreach($menu AS $nMenu => $m){
				if($m['rights'] >=0 ){
					if($m['rights'] <= $this->rights){
						$this->displayElement($m, $link, $nMenu);
					}
				}
				else{
					if(abs($m['rights']) > $this->rights){
						$this->displayElement($m, $link, $nMenu);
					}
				}
			}
			echo '</ul>'."\n";
		}
		
		private function displayElement($element, $link, $nMenu){
			$active = false;
			$link[] = $nMenu;
			$url = implode(':', $link);
			echo "\t".'<li>'."\n\t\t".'<a ';
			$p=explode(':', Page::getPagePath());
			$active = true;
			foreach($link AS $kLink =>$vLink){
				if(isset($p[$kLink]) AND $p[$kLink] != $link[$kLink]){
					$active = false;
				}
			}
			if($active){
				echo 'class="active" ';
			}
			echo 'href="'.Page::createPageLink($url).'">' . Page::htmlEncode($element['title']) . '</a>'."\n";
			if(isset($element['menu'])){
				$this->displayMenu($element['menu'], $link);
			}
			echo "\t".'</li>'."\n";
		}
	}
?>