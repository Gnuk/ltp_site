<?php

namespace gnk\controller\rest\services;

/**
* Classe de statuts pour REST
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 01/12/2012
* @see Services
* @namespace gnk\controller\rest\services
*/
class Statuses extends \gnk\controller\rest\Services{
	private $statuses;
	
	public function __construct($statuses){
		$this->statuses = $statuses;
	}
	
	public function toArray(){
		if(count($this->serviceArray) == 0){
			parent::toArray();
			foreach($this->statuses AS $nStatus => $status){
				$this->serviceArray['ltp']['statuses'][$nStatus]['lon'] = $status['longitude'];
				$this->serviceArray['ltp']['statuses'][$nStatus]['lat'] = $status['latitude'];
				$this->serviceArray['ltp']['statuses'][$nStatus]['content'] = $status['message'];
				$this->serviceArray['ltp']['statuses'][$nStatus]['time'] = $status['date']->format('Y-m-d\TH:i:sP');
			}
		}
		return $this->serviceArray;
	}
}

?>