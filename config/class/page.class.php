<?php
	class Page{

		public static function show($getName = 'p', $defaultPage = 'home'){
			if(isset($_GET[$getName]) AND is_file(LINK_PAGES . $_GET[$getName] . '.page.php')){
				require_once(LINK_PAGES . $_GET[$getName] . '.page.php');
			}
			else if(is_file(LINK_PAGES . $defaultPage . '.page.php')){
				require_once(LINK_PAGES . $defaultPage . '.page.php');
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
		* Affiche le header standard de la page
		* @param string $title
		* @param string $description
		* @param string $tags
		* @param string $author
		* @param string $css
		* @todo Implémenter la méthode stdHeader
		*/
		public static function stdHeader($title = null, $description = null, $tags = null, $author = null, $css = null){
			# Not implemented
		}
		
		/**
		* Affiche le footer standard de la page
		* @param string $copyright
		* @todo Implémenter la méthode stdFooter
		*/
		public static function stdFooter($copyright = null){
			# Not implemented
		}
	}
?>