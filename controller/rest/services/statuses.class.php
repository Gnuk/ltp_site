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
	
	/**
	* Constructeur
	* @param array $statuses Les statuts de l'utilisateur sous forme de tableau depuis la base de données
	*/
	public function __construct($statuses){
		$this->statuses = $statuses;
	}
	
	/**
	* Génération du tableau (en fonction de l'API REST)
	* @see toArray dans la classe Services
	* @return array Le tableau généré
	*/
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