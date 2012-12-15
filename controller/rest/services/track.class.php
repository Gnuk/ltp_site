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
use \gnk\config\Database;

/**
* Classe de statut pour REST
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 15/12/2012
* @see Services
* @namespace gnk\controller\rest\services
*/
class Track extends \gnk\controller\rest\Services{
	private $lon;
	private $lat;
	private $user;
	private $em;
	
	/**
	* Constructeur
	* @param array $statuses Les statuts de l'utilisateur sous forme de tableau depuis la base de données
	*/
	public function __construct($lon, $lat, $user){
		$this->lon = $lon;
		$this->lat = $lat;
		$this->user = $user;
	}
	
	/**
	* Génération du tableau (en fonction de l'API REST)
	* @see toArray dans la classe Services
	* @return array Le tableau généré
	*/
	public function toArray(){
		if(count($this->serviceArray) == 0){
			parent::toArray();
				$this->serviceArray['ltp']['track']['lon'] = $this->lon;
				$this->serviceArray['ltp']['track']['lat'] = $this->lat;
		}
		return $this->serviceArray;
	}
	
	public static function createTrack($array, $user){
		if(
			isset($array['ltp']['track']['lon'])
			AND is_numeric($array['ltp']['track']['lon'])
			AND isset($array['ltp']['track']['lat'])
			AND is_numeric($array['ltp']['track']['lat'])
		){
			$status = new Track(
				$array['ltp']['track']['lon'],
				$array['ltp']['track']['lat'],
				$user
			);
			return $status;
		}
		else{
			return false;
		}
	}
	
	public function save(){
		Database::useTables();
		$this->em = Database::getEM();
		$this->user->setLonLat($this->lon, $this->lat);
		$this->em->persist($this->user);
		$this->em->flush();
	}
}

?>