<?php
	namespace gnk\controller;
	use \gnk\config\Model;
	use \gnk\config\Module;
	use \gnk\config\Page;
	use \gnk\modules\osm\Osm;
	use \gnk\modules\osm\Marker;
	use \gnk\modules\form\Form;
	Model::load('statusmanager');
	
	class StatusManager{
		private $status = array();
		private $add = false;
		private $sendForm = false;
		
		public function __construct(){
			$this->model = new \gnk\model\StatusManager();
			$this->sendForm = $this->addStatus();
			$this->status = $this->model->getStatuses();
		}
		public function getMap($divName='carte'){
			Module::load('osm');
			$osm = new Osm($divName);
			if(!isset($_GET['add'])){
				if(count($this->status) > 0){
					$markers = $this->getMarkersStatus();
					$osm->addMarker($markers);
				}
			}
			else{
				$osm->addPicker();
			}
			$osm->setJS();
			return $osm;
		}
		
		
		public function getAddForm($longitude, $latitude){
			Module::load('form');
			$form = new Form('status');
			
			$form->add('label', 'label_message', 'message', T_('Message :'));
			$obj = & $form->add('textarea', 'message');
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Vous devez ajouter un message.')),

			));
			
			$form->add('label', 'label_longitude', 'longitude', T_('Longitude :'));
			$obj = & $form->add('text', 'longitude', $longitude);
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Vous devez indiquer une longitude.')),

			));
			
			$form->add('label', 'label_latitude', 'latitude', T_('Latitude :'));
			$obj = & $form->add('text', 'latitude', $latitude);
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Vous devez indiquer une latitude.')),

			));
			
			$form->add('submit', 'btnsubmit', T_('Indiquer le statut'));
			return $form;
		}
		
		public function getEditForm(){
			Module::load('form');
			$form = new Form('status');
			
			$form->add('label', 'label_message', 'message', T_('Message :'));
			$obj = & $form->add('textarea', 'message');
			$obj->set_rule(array(
				'required'  =>  array('error', T_('Vous devez ajouter un message.')),

			));
			
			$form->add('submit', 'btnsubmit', T_('Modifier le statut'));
			return $form;
		}
		
		private function getMarkersStatus(){
			$marker = new Marker(T_('Status'));
			foreach($this->status as $nStatus => $stat){
				$marker->add($stat['longitude'] ,$stat['latitude'], '<p>'.Page::htmlEncode($stat['message']).'</p><ul><li><a href="'.Page::getLink(array('edit' => $stat['id'])).'">'.T_('Éditer').'</a></li><li><a href="'.Page::getLink(array('delete' => $stat['id'])).'">'.T_('Supprimer').'</a></li></ul>');
			}
			return $marker;
		}
		
		
		
		public function getStatus(){
			return $this->status;
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