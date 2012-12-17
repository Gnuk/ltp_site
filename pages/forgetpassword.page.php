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
	use \gnk\config\Module;
	use \gnk\modules\form\Form;
	use \gnk\config\Controller;
	Controller::load('passwordmanager');
	if(Page::haveRights()){
		$controller = new \gnk\controller\PasswordManager();
		Module::load('form');
		$template = new Template();
		if($controller->isConfirm()){
			$title = T_('Définition du nouveau mot de passe');
			
			$form = new Form('changepassword');
			$form->add('label', 'label_pass', 'pass', T_('Mot de passe :'));
			$obj = & $form->add('password', 'pass');
			$passFrom = 6;
			$passTo = 50;
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Veuillez préciser votre nouveau mot de passe.')),
				'length'    => array($passFrom, $passTo, 'error', sprintf(T_('Votre mot passe doit être composé de %d à %d caractères.'), $passFrom, $passTo))
			));
			$form->add('note', 'note_password', 'password', sprintf(T_('Votre mot passe doit être composé de %d à %d caractères.'), $passFrom, $passTo));
			$form->add('label', 'label_confirmpass', 'confirmpass', T_('Confirmation :'));
			$obj = & $form->add('password', 'confirmpass');
			$obj->set_rule(array(
				'compare' => array('pass', 'error', T_('Les mots de passes ne correspondent pas.'))

			));
			$form->add('submit', 'btnsubmit', T_('Définir mon mot de passe'));
		}
		else{
			$title = T_('Mot de passe oublié ?');
			
			$form = new Form('forgetpassword');
			$form->add('label', 'label_user', 'user', T_('Identifiant :'));
			$obj = & $form->add('text', 'user');
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Veuillez préciser votre identifiant.')),

			));
			$form->add('submit', 'btnsubmit', T_('Récupérer mon mot de passe'));
		}
		
		$template = new Template();
		$template->addTitle($title);
		$template->setDescription(T_('Récupération du mot de passe.'));
		$template->addKeywords(array(T_('mot de passe'), T_('oublié')));
		$template->show('header_full');
?>
<h1><?php echo Page::htmlEncode($title); ?></h1>
<?php
		$form->render();
		$template->show('footer_full');
	}
	else{
		Page::showDefault();
	}
?>