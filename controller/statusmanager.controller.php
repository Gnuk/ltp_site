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
	
	/**
	* Gestion des statuts
	* @author Anthony REY <anthony.rey@mailoo.org>
	*/
	class StatusManager extends Controller{
		private $statuses = array();
		private $addStat = false;
		private $model;
		private $edit = NULL;
		private $add = false;
		private $delete = NULL;
		
		public function __construct(){
			parent::__construct();
			$this->loadGet();
			$this->loadModel('statusmanager');
			$this->model = new \gnk\model\StatusManager();
			$this->addStatus();
			$this->updateStatus();
			$this->delStatus();
			$this->statuses = $this->model->getStatuses();
		}
		
		public function isAdd(){
			return $this->add;
		}
		
		public function isEdit(){
			if(isset($this->edit)){
				return true;
			}
			else{
				return false;
			}
		}
		
		public function isDelete($param){
			if(isset($this->delete[$param])){
				return true;
			}
			else{
				return false;
			}
		}
		
		public function getDelete(){
			if(isset($this->delete['id'])){
				return $this->delete['id'];
			}
			else{
				return 0;
			}
		}
		
		private function loadGet(){
			if(isset($this->params[0])){
				if($this->params[0] == 'add'){
					$this->add = true;
				}
				else if($this->params[0] == 'edit'){
					if(isset($this->params[1]) AND is_numeric($this->params[1])){
						$this->edit = $this->params[1];
					}
				}
				else if($this->params[0] == 'delete'){
					if(isset($this->params[1]) AND is_numeric($this->params[1])){
						$this->delete['id'] = $this->params[1];
					}
					if(isset($this->params[2]) AND $this->params[2] == 'confirm'){
						$this->delete['confirm'] = true;
					}
				}
			}
		}
		public function getMap($divName='carte'){
			Module::load('osm');
			$osm = new Osm($divName);
			if(!$this->add){
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
			$message = '';
			Module::load('form');
			$form = new Form('statuses');
			
			$form->add('label', 'label_message', 'message', T_('Message :'));
			if(isset($this->edit)){
				$message = $this->model->getStatusMessage($this->edit);
			}
			$obj = & $form->add('textarea', 'message', Page::htmlEncode($message));
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Vous devez ajouter un message.')),

			));
			
			$form->add('submit', 'btnsubmit', T_('Modifier le statut'));
			return $form;
		}
		
		private function getMarkersStatuses(){
			$marker = new Marker(T_('Statuts'));
			foreach($this->statuses as $nStatus => $stat){
				$marker->add($stat['longitude'] ,$stat['latitude'], '<p>'.Page::htmlBREncode($stat['message']).'</p><ul><li><a href="'.Page::paramsLink(array('edit', $stat['id'])).'">'.Page::getImage('edit', T_('Éditer'), 16).'</a></li><li><a href="'.Page::paramsLink(array('delete' , $stat['id'])).'">'.Page::getImage('delete', T_('Supprimer'), 16).'</a></li></ul>');
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
				AND isset($this->edit))
			{
				return $this->model->editStatus($this->edit, $_POST['message']);
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
				AND !isset($this->edit))
			{
				$this->addStat = $this->model->addStatus($_POST['message'], $_POST['longitude'], $_POST['latitude']);
				return $this->addStat;
			}
			return false;
		}
		
		public function delStatus(){
			if(
				isset($this->delete['id'])
				AND isset($this->delete['confirm'])
			){
				return $this->model->delStatus($this->delete['id']);
			}
		}
	}
?>