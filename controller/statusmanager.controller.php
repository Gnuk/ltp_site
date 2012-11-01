<?php
	namespace gnk\controller;
	use \gnk\config\Model;
	use \gnk\config\Module;
	use \gnk\config\Page;
	use \gnk\modules\osm\Osm;
	use \gnk\modules\osm\Marker;
	Model::load('statusmanager');
	
	class StatusManager{
		private $status = array();
		public function __construct(){
			$this->model = new \gnk\model\StatusManager();
			$this->status = $this->model->getStatuses();
		}
		public function getMap(){
			Module::load('osm');
			$osm = new Osm('carte');
			if(count($this->status) > 0){
				$markers = self::getMarkersStatus();
				$osm->addMarker($markers);
			}
			$osm->setJS();
			return $osm;
		}
		
		private function getMarkersStatus(){
			$marker = new Marker(T_('Status'));
			foreach($this->status as $nStatus => $stat){
				$marker->add($stat['longitude'] ,$stat['latitude'], '<p>'.Page::htmlEncode($stat['message']).'</p>');
			}
			return $marker;
		}
	}
?>