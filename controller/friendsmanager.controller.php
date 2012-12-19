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
use \gnk\config\Controller;
use \gnk\config\Module;
use \gnk\modules\form\Form;
use \gnk\modules\osm\Osm;
use \gnk\modules\osm\Marker;

/**
* Contrôleur des amis
*/
class FriendsManager extends Controller{
	private $model;
	private $add;
	
	public function __construct(){
		$this->loadModel('friendsmanager');
 		$this->model = new \gnk\model\FriendsManager();
		$this->addFriend();
		$this->haveFriends();
	}
	
	/**
	* Récupération du formulaire d'ajout d'un utilisateur à une liste
	* @param string $get La méthode get correspondant au type d'utilisateur à envoyer (seeme ou want)
	*/
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
	
	/**
	* Récupération des erreurs du modèle
	* @return array Le tableau contenant les erreurs
	*/
	public function getModelErrors(){
		return $this->model->getErrors();
	}
	
	/**
	* Ajout d'un ami
	* @return boolean True si l'ajout a réussi ou False sinon
	*/
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
		
	/**
	* Récupération de la liste de contacts
	* @param $friends la liste des contacts de l'utilisateur
	*/
	public function getFriends(){
		return $this->friends;
	}
	
	private function haveFriends(){
		$list = $this->model->getFriends();
		$i=0;
		$friends = array();
		
		while(isset($list[$i])){
			$user = $list[$i];
			$longitude = $user->getLongitude();
			$latitude = $user->getLatitude();
			$friends[$i]['id'] = $user->getId();
			$friends[$i]['login'] = $user->getLogin();
			if(isset($longitude) AND isset($latitude)){
				$friends[$i]['lon'] = $longitude;
				$friends[$i]['lat'] = $latitude;
			}
			if(is_object($user->getStatuses()->last())){
				$friends[$i]['status'] = $user->getStatuses()->last()->getMessage();
			}
			else{
				$friends[$i]['status'] = false;
			}
			$i++;
		}
		$this->friends = $friends;
	}
	
	public function getMapFriends($name){
		$isFriend = false;
		Module::load('osm');
		$osm = new Osm($name);
		$marker = new Marker(T_('Mes amis'));
		foreach($this->friends AS $nFriend => $friend){
			if(
				isset($friend['lon'])
				AND isset($friend['lat'])
			){
				$isFriend = true;
				if($friend['status']){
					$html = '<h1>'.Page::htmlBREncode($friend['login']).'</h1>';
					$html .= '<p>'.Page::htmlBREncode($friend['status']).'</p>';
					$marker->add($friend['lon'], $friend['lat'], $html);
				}
				else{
					$marker->add($friend['lon'], $friend['lat']);
				}
			}
		}
		if($isFriend){
			$osm->addMarker($marker);
		}
		$osm->setJS();
		return $osm;
	}
	
	public function getWanted(){
		$list = $this->model->getWanted();
		$i=0;
		$friends = array();
		
		while(isset($list[$i])){
			$user = $list[$i];
			$friends[$i]['id'] = $user->getId();
			$friends[$i]['login'] = $user->getLogin();
			$i++;
		}
		return $friends;
	}
	
	public function getWantMe(){
		$list = $this->model->getWantMe();
		$i=0;
		$friends = array();
		
		while(isset($list[$i])){
			$user = $list[$i];
			$friends[$i]['id'] = $user->getId();
			$friends[$i]['login'] = $user->getLogin();
			$i++;
		}
		return $friends;
	}
	
	public function getSeeMe(){
		$list = $this->model->getSeeMe();
		$i=0;
		$friends = array();
		
		while(isset($list[$i])){
			$user = $list[$i];
			$friends[$i]['id'] = $user->getId();
			$friends[$i]['login'] = $user->getLogin();
			$i++;
		}
		return $friends;
	}
}

?>