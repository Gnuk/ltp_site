<?php
	use \gnk\config\Config;
	use \gnk\config\Page;
?>
			<p>
				Copyright © <?php echo Config::getYear(); ?> OpenTeamMap | <a href="<?php echo Page::createPageLink('licenses'); ?>"><?php echo T_('Droits d\'auteur');?></a>
			</p>
			<p>
				<?php
					$licence = Config::getLicense();
					$htmlLicense = '<a href="'.$licence['url'].'" title="'.$licence['name'].'">'.$licence['name'].'</a>';
					echo T_('Le code source de ce site est sous licence') . ' ' . $htmlLicense; ?>
			</p>