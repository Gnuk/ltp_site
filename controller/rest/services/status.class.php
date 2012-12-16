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
* @since 13/12/2012
* @see Services
* @namespace gnk\controller\rest\services
*/
class Status extends \gnk\controller\rest\Services{
	private $content;
	private $lon;
	private $lat;
	private $user;
	private $em;
	
	/**
	* Constructeur
	* @param array $statuses Les statuts de l'utilisateur sous forme de tableau depuis la base de données
	*/
	public function __construct($content, $lon, $lat, $user){
		$this->content = $content;
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
				$this->serviceArray['ltp']['status']['lon'] = $this->lon;
				$this->serviceArray['ltp']['status']['lat'] = $this->lat;
				$this->serviceArray['ltp']['status']['content'] = $this->content;
		}
		return $this->serviceArray;
	}
	
	public static function createStatus($array, $user){
		if(
			isset($array['ltp']['status']['lon'])
			AND is_numeric($array['ltp']['status']['lon'])
			AND isset($array['ltp']['status']['lat'])
			AND is_numeric($array['ltp']['status']['lat'])
			AND isset($array['ltp']['status']['content'])
		){
			$status = new Status(
				$array['ltp']['status']['content'],
				$array['ltp']['status']['lon'],
				$array['ltp']['status']['lat'],
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
		$status = new \gnk\database\entities\Statuses($this->user, $this->content, $this->lon, $this->lat);
		# Met à jour la longitude et la latitude chez l'utilisateur (facultatif)
		$this->user->setLonLat($this->lon, $this->lat);
		$this->em->persist($status);
		$this->em->flush();
	}
}

?>