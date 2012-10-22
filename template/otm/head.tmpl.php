<?php
	use \gnk\config\Page;
		Page::addCSS($this->getLink() . 'styles/style.css');
?>
		<meta charset="UTF-8" />
		<title><?php echo T_('LocalizeTeaPot');?></title>
		<link rel="shortcut icon" href="<?php echo $this->getLink();?>images/icone.png" />
		<?php Page::showCSS();?>