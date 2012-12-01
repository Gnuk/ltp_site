
<?php
	use \gnk\config\Page;
	use \gnk\config\Config;
?>
			<h1>
				<a href="<?php echo Page::defaultPageLink();?>">
					<img id="iconeAccueil" src="<?php echo $this->getLink();?>images/icone_accueil.png" alt="<?php
					$global = Config::getWebsiteConfig();
					if(isset($global['title'])){
						echo Page::htmlEncode($global['title']);
					}
					else{
						echo Page::htmlEncode(T_('Mon site'));
					}?>" />
				</a>
			</h1>
			<nav id="menu">
				<?php $this->showMenu(); ?>
			</nav>