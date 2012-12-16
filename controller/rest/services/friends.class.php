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
* Classe de contacts pour REST
* @author Benjamin NARETTO <benjamin.naretto@etu.univ-savoie.fr>
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 12/12/2012
* @see Services
* @namespace gnk\controller\rest\services
*/
class Friends extends \gnk\controller\rest\Services{
	private $friends;
	
	/**
	* Constructeur
	* @param array $friends Les contacts de l'utilisateur sous forme de tableau depuis la base de données
	*/
	public function __construct($friends){
		$this->friends = $friends;
	}
	
	/**
	* Génération du tableau (en fonction de l'API REST)
	* @see toArray dans la classe Services
	* @return array Le tableau généré
	*/
	public function toArray(){
		if(count($this->serviceArray) == 0){
			parent::toArray();
			foreach($this->friends AS $nFriend => $friend){
				$this->serviceArray['ltp']['friends'][$nFriend]['username'] = $friend['login'];
				if(isset($friend['longitude']) AND isset($friend['latitude'])){
					$this->serviceArray['ltp']['friends'][$nFriend]['lon'] = $friend['longitude'];
					$this->serviceArray['ltp']['friends'][$nFriend]['lat'] = $friend['latitude'];
				}
				if(isset($friend['trackdate'])){
					$this->serviceArray['ltp']['friends'][$nFriend]['time'] = $friend['trackdate']->format('Y-m-d\TH:i:sP');
				}
			}
		}
		return $this->serviceArray;
	}
}

?>