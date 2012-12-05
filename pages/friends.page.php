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
	use \gnk\config\Template;
	use \gnk\config\Controller;
	Controller::load('friendsmanager');
	
	if(Page::haveRights(3)){
		$controller = new \gnk\controller\FriendsManager();
		$formWant = $controller->getForm('want');
		$formSeeMe = $controller->getForm('seeme');
		$template = new Template();
		$template->addTitle(T_('Amis'));
		$template->setDescription(T_('Gestion des amis.'));
		$template->addKeywords(array(T_('amis')));
		$template->show('header_full');
?>
	<article>
		<h1><?php echo T_("Amis");?></h1>
		<section id="myfriends">
			<h2><?php echo T_('Mes Amis') ;?></h2>
			<p>Not Implemented</p>
		</section>
		<section id="friendswantme">
			<h2><?php echo T_('Demandes en cours') ;?></h2>
			<?php
				$formWant->render();
			?>
			<p>Not Implemented</p>
		</section>
		<section id="friendsseeme">
			<h2><?php echo T_('Me voient') ;?></h2>
			<?php
				$formSeeMe->render();
			?>
			<p>Not Implemented</p>
		</section>
	</article>
<?php
		$template->show('footer_full');
	}
	else{
		Page::showDefault();
	}
?>