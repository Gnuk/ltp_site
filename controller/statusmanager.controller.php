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
	use \gnk\config\Controller;
	use \gnk\config\Module;
	use \gnk\config\Page;
	use \gnk\modules\osm\Osm;
	use \gnk\modules\osm\Marker;
	use \gnk\modules\form\Form;
	
	class StatusManager extends Controller{
		private $statuses = array();
		private $add = false;
		private $sendForm = false;
		private $model;
		
		public function __construct(){
			$this->loadModel('statusmanager');
			$this->model = new \gnk\model\StatusManager();
			$this->sendForm = $this->addStatus();
			$this->statuses = $this->model->getStatuses();
		}
		public function getMap($divName='carte'){
			Module::load('osm');
			$osm = new Osm($divName);
			if(!isset($_GET['add'])){
				if(count($this->statuses) > 0){
					$markers = $this->getMarkersStatuses();
					$osm->addMarker($markers);
				}
			}
			else{
				$osm->addPicker();
			}
			$osm->setJS();
			return $osm;
		}
		
		
		public function getAddForm(){
			Module::load('form');
			$form = new Form('statuses');
			
			$form->add('label', 'label_message', 'message', T_('Message :'));
			$obj = & $form->add('textarea', 'message');
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Vous devez ajouter un message.')),

			));
			
			$form->add('label', 'label_longitude', 'longitude', T_('Longitude :'));
			$obj = & $form->add('text', 'longitude');
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Vous devez indiquer une longitude.')),

			));
			
			$form->add('label', 'label_latitude', 'latitude', T_('Latitude :'));
			$obj = & $form->add('text', 'latitude');
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Vous devez indiquer une latitude.')),

			));
			
			$form->add('submit', 'btnsubmit', T_('Indiquer le statut'));
			return $form;
		}
		
		public function getEditForm(){
			Module::load('form');
			$form = new Form('statuses');
			
			$form->add('label', 'label_message', 'message', T_('Message :'));
			$obj = & $form->add('textarea', 'message');
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Vous devez ajouter un message.')),

			));
			
			$form->add('submit', 'btnsubmit', T_('Modifier le statut'));
			return $form;
		}
		
		private function getMarkersStatuses(){
			$marker = new Marker(T_('Statuses'));
			foreach($this->statuses as $nStatus => $stat){
				$marker->add($stat['longitude'] ,$stat['latitude'], '<p>'.Page::htmlBREncode($stat['message']).'</p><ul><li><a href="'.Page::getLink(array('edit' => $stat['id'])).'">'.T_('Éditer').'</a></li><li><a href="'.Page::getLink(array('delete' => $stat['id'])).'">'.T_('Supprimer').'</a></li></ul>');
			}
			return $marker;
		}
		
		
		
		public function getStatuses(){
			return $this->statuses;
		}
		
		/**
		* Mise à jour des statuts
		* @todo Implémenter l'édition d'un statut
		*/
		public function updateStatus(){
			if(isset($_POST['message']) 
				AND isset($_POST['longitude']) 
				AND is_numeric($_POST['longitude']) 
				AND isset($_POST['latitude']) 
				AND is_numeric($_POST['latitude']) 
				AND isset($_GET['edit']))
			{
				return true;
			}
			return false;
		}
		
		/**
		* Ajout de status
		*/
		public function addStatus(){
			if(isset($_POST['message']) 
				AND isset($_POST['longitude']) 
				AND is_numeric($_POST['longitude']) 
				AND isset($_POST['latitude']) 
				AND is_numeric($_POST['latitude']) 
				AND !isset($_GET['edit']))
			{
				$this->add = $this->model->addStatus($_POST['message'], $_POST['longitude'], $_POST['latitude']);
				return $this->add;
			}
			return false;
		}
	}
?>