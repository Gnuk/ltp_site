
<?php
	use \gnk\config\Page;
?>
			<h1>
				<a href="<?php echo Page::getLink(array('p' => Page::getDefaultPage()), false);?>">
					<img id="iconeAccueil" src="<?php echo $this->getLink();?>images/icone_accueil.png" alt="<?php echo T_('Accueil');?>" />
				</a>
			</h1>