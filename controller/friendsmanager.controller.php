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
namespace gnk\controller;
use \gnk\config\Page;
use \gnk\config\Model;
use \gnk\config\Module;
use \gnk\modules\form\Form;
Model::load('friendsmanager');

/**
* Contrôleur des amis
*/
class FriendsManager{
	private $model;
	private $add;
	
	public function __construct(){
 		$this->model = new \gnk\model\FriendsManager();
		$this->addFriend();
	}
	
	public function getForm($get){
		Module::load('form');
		$form = new Form('form_'.$get, 'POST', Page::getLink(array($get => null), true, false));
		$form->add('label', 'label_login_'.$get, 'login', T_('Utilisateur : '));
		$obj = & $form->add('text', 'login');
		$obj->set_rule(array(
			'required'  =>  array('error', T_('Vous indiquer votre identifiant.')),

		));
		$form->add('submit', 'btnsubmit', T_('Ajouter'));
		return $form;
	}
	
	public function addFriend(){
		if(
			isset($_POST['login'])
		)
		{
			if(isset($_GET['want'])){
				$this->add = $this->model->addFriendWanted($_POST['login']);
			}
			else if(isset($_GET['seeme'])){
				$this->add = $this->model->addFriendSeeMe($_POST['login']);
			}
			return $this->add;
		}
		return false;
	}
}

?>