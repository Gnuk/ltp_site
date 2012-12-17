<?php
/*
*
* Copyright (c) 2012 OpenTeamMap
*
* This file is part of LocalizeTeaPot.
*
* LocalizeTeaPot is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* LocalizeTeaPot is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with LocalizeTeaPot.  If not, see <http://www.gnu.org/licenses/>.
*/

	use \gnk\config\Config;
	use \gnk\config\Page;
?>
			<p>
				Copyright © <?php echo Config::getYear(); ?> OpenTeamMap | <a href="<?php echo Page::createPageLink('licenses'); ?>"><?php echo T_('À propos');?></a>
			</p>
			<p>
				<?php
					$licence = Config::getLicense();
					$contentLicence = Config::getContentLicense();
					$htmlLicense = '<a href="'.$licence['url'].'" title="'.$licence['name'].'">'.$licence['name'].'</a>';
					$htmlContentLicense = '<a href="'.$contentLicence['url'].'" title="'.$contentLicence['name'].'">'.$contentLicence['name'].'</a>';
					echo sprintf(T_('Le code source de ce site est sous licence %s et son contenu sous %s'), $htmlLicense, $htmlContentLicense); ?>
			</p>