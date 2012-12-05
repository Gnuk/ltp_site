
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