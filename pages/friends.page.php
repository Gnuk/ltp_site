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
		
		$osm = $controller->getMapFriends('friends_map');
		
		$formWant = $controller->getForm('want');
		$formSeeMe = $controller->getForm('seeme');
		
		
		$template = new Template();
		$template->addTitle(T_('Amis'));
		$template->setDescription(T_('Gestion des amis.'));
		$template->addKeywords(array(T_('amis')));
		$template->show('header_full');
?>
	<article id="friends">
		<h1><?php echo T_("Amis");?></h1>
<?php
			if(count($errors = $controller->getModelErrors()) > 0){
					Page::displayErrors($errors);
			}
			if((isset($_GET['delWant']) OR isset($_GET['delSee'])) AND !isset($_GET['confirm'])){
				if(isset($_GET['delWant'])){
					$delAction = 'delWant';
					$delValue = $_GET['delWant'];
					$delText = T_('Voulez-vous supprimer cette personne de votre liste d\'amis ?');
				}
				else{
					$delAction = 'delSee';
					$delValue = $_GET['delSee'];
					$delText = T_('Voulez-vous empêcher cette personne de vous voir ?');
				}
?>
		<div class="delete">
			<p><?php echo $delText;?></p>
			<ul>
				<li><a href="<?php echo Page::getLink(array($delAction => $delValue, 'confirm' => '')); ?>">Oui</a></li>
				<li><a href="<?php echo Page::getLink() ;?>">Non</a></li>
			</ul>
		</div>
<?php
			}
?>
		<section id="friendsMapzone">
		<h2><?php echo T_("La carte");?></h1>
		<?php
			$osm->showDiv();
		?>
		</section>
		<section id="myfriends">
			<h2><?php echo T_('Mes Amis') ;?></h2>
			<?php
				$friends = $controller->getFriends();
				if(count($friends) > 0){
					echo '<table>';
					echo '<tr>';
					echo '<th>'.Page::htmlEncode(T_('Nom')).'</th>';
					echo '<th>'.Page::htmlEncode(T_('Dernier statut')).'</th>';
					echo '<th>'.Page::htmlEncode(T_('Actions')).'</th>';
					echo '</tr>';
					foreach($friends AS $nFriend => $friend){
						echo '<tr>';
						echo '<td>'.Page::htmlEncode($friend['login']).'</td>';
						echo '<td>';
						if($friend['status']){
							echo Page::htmlBREncode($friend['status']);
						}
						else{
							echo Page::htmlEncode(T_('Aucun de statut'));
						}
						echo '</td>';
						echo '<td>';
						echo '<a href="'. Page::getLink(array('delWant' => $friend['id'])) .'">'.Page::getImage('delete', T_('Supprimer de ma liste'), 16) . '</a>';
						echo '</td>';
						echo '</tr>';
					}
					echo '</table>';
				}
				else{
			?>
			<p>
				<?php echo T_('Vous n\'avez encore aucun amis') ;?>
			</p>
			<?php
				}
			?>
		</section>
		<section id="friendsiwant">
			<h2><?php echo T_('Mes demandes en cours') ;?></h2>
			<?php
				$formWant->render();
				
				$wanted = $controller->getWanted();
				if(count($wanted) > 0){
					echo '<table>';
					echo '<tr>';
					echo '<th>'.Page::htmlEncode(T_('Nom')).'</th>';
					echo '<th>'.Page::htmlEncode(T_('Actions')).'</th>';
					echo '</tr>';
					foreach($wanted AS $nWanted => $want){
						echo '<tr>';
						echo '<td>'.Page::htmlEncode($want['login']).'</td>';
						echo '<td>';
						echo '<a href="'. Page::getLink(array('delWant' => $want['id'])) .'">'.Page::getImage('delete', T_('Supprimer de ma liste'), 16) . '</a>';
						echo '</td>';
						echo '</tr>';
					}
					echo '</table>';
				}
			?>
		</section>
		<section id="friendsseeme">
			<h2><?php echo T_('Ceux qui me voient') ;?></h2>
			<?php
				$formSeeMe->render();
				$seeme = $controller->getSeeMe();
				if(count($seeme) > 0){
					echo '<table>';
					echo '<tr>';
					echo '<th>'.Page::htmlEncode(T_('Nom')).'</th>';
					echo '<th>'.Page::htmlEncode(T_('Actions')).'</th>';
					echo '</tr>';
					foreach($seeme AS $nSeeme => $see){
						echo '<tr>';
						echo '<td>'.Page::htmlEncode($see['login']).'</td>';
						echo '<td>';
						echo '<a href="'. Page::getLink(array('delSee' => $see['id'])) .'">'.Page::getImage('delete', T_('Supprimer de ma liste'), 16) . '</a>';
						echo '</td>';
						echo '</tr>';
					}
					echo '</table>';
				}
			?>
		</section>
			<?php
				$wantme = $controller->getWantMe();
				if(count($wantme) > 0){
?>
		<section id="friendswantme">
			<h2><?php echo T_('Ceux qui veulent me voir') ;?></h2>
<?php
					echo '<table>';
					echo '<tr>';
					echo '<th>'.Page::htmlEncode(T_('Nom')).'</th>';
					echo '</tr>';
					foreach($wantme AS $nWantm => $wantm){
						echo '<tr>';
						echo '<td>'.Page::htmlEncode($wantm['login']).'</td>';
						echo '</tr>';
					}
					echo '</table>';
?>
		</section>
<?php
				}
			?>
	</article>
<?php
		$template->show('footer_full');
	}
	else{
		Page::showDefault();
	}
?>