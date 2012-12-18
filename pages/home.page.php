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
	use \gnk\config\Module;
	use \gnk\modules\osm\Osm;
	use \gnk\modules\osm\Marker;
	use \gnk\config\Template;
	use \gnk\modules\form\Form;
	if(Page::haveRights()){
		Module::load('osm');
		$osm = new Osm('carte');
		$markers = new Marker(T_('À propos de vous'));
		$markers->add(null, null, '<p>'.Page::htmlBREncode(T_('Il semble que vous êtes ici')).'</p>');
		$osm->addMarker($markers);
		$osm->setJS();
		Module::load('form');
		$form = new Form('form', $method = 'POST', $action = Page::getLink(array('connection' => null), true, false));
		$form->add('label', 'label_login', 'login', T_('Identifiant : '));
		$obj = & $form->add('text', 'login');
		$obj->set_rule(array(
			'required'  =>  array('error', T_('Vous indiquer votre identifiant.')),

		));
		// "password"
		$form->add('label', 'label_password', 'password', T_('Mot de passe : '));
		$obj = & $form->add('password', 'password');
		$obj->set_rule(array(
			'required'  => array('error', T_('Veuillez indiquer votre mot de passe.'))
		));
		
		$form->add('submit', 'btnsubmit', T_('Se connecter'));
		$template = new Template();
		$template->addTitle(T_('Accueil'));
		$template->show('header_full');
?>
			<article>
<?php
		if(Config::isUser()){
?>
				<h1><?php echo Page::htmlEncode(sprintf(T_('Bienvenue %s'), Page::htmlEncode($_SESSION['user'])));?></h1>
				<p><a href="?disconnection"><?php echo T_('Se déconnecter'); ?></a></p>
<?php
		}
		else{
?>
				<h1><?php echo T_('Bienvenue sur LocalizeTeaPot');?></h1>
<?php
			if($form->validate()){
				if(count($info = Config::getInfo())){ ?>
				<ul class="form_error">
<?php
					foreach ($info as $nInfo => $valueInfo){ ?>
					<li><?php echo Page::htmlEncode($valueInfo); ?></li>
<?php
					} ?>
				</ul>
<?php
				}
			}
?>
				<section id="homeDescription">
					<div id="homePhone">
						<?php $osm->showDiv() ?>
					</div>
					<div id="homeDesc">
						<p>
<?php
			echo T_('LoacalizeTeaPot est une application qui vous permet localiser tout vos amis, partout dans le monde, en quelques clics! 
Envie de retrouver vos amis autour d’une bonne tasse de thé? Connectez vous dès maintenant pour voir qui est proche de vous!');
?>
						</p>
						<p>
<?php
			echo sprintf(T_('Pas encore inscrit? Créez votre compte via l’onglet Inscription ci-dessus ou en cliquant juste %sici%s !'), '<a href="'. Page::createPageLink('inscription').'">', '</a>');
?>
						</p>
						<p>
<?php

			echo T_('Vous voulez emportez vos amis partout avec vous? Téléchargez l’application Android, LocalizeTeaPot sans plus tarder !');
?>
						</p>
					</div>
				</section>
				<section id="homeLogin">
<?php
			$form->render();
?>
					<p>
						<a href="<?php echo Page::createPageLink('forgetpassword'); ?>" title="<?php echo Page::htmlEncode(T_('Mot de passe oublié')); ?>"><?php echo Page::htmlEncode(T_('Mot de passe oublié')); ?></a> |
						<a href="<?php echo Page::createPageLink('inscription'); ?>" title="<?php echo Page::htmlEncode(T_('S\'inscrire')); ?>"><?php echo Page::htmlEncode(T_('S\'inscrire')); ?></a>
					</p>
				</section>
<?php
		}
		if(Config::isUser()){
			$osm->showDiv();
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