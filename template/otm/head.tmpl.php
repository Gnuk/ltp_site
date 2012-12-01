<?php
	use \gnk\config\Page;
		Page::addCSS($this->getLink(false) . 'styles/style.css');
?>
		<meta charset="UTF-8" />
<?php $this->showWebsiteParams();?>
		<link rel="shortcut icon" href="<?php echo $this->getLink();?>images/icone.png" />
		<?php Page::showCSS();?>