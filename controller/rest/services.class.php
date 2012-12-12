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

namespace gnk\controller\rest;
use \gnk\config\Module;
use \gnk\config\Config;
use \gnk\config\Page;

require_once(LINK_CONTROLLER . 'rest/services/user.class.php');
require_once(LINK_CONTROLLER . 'rest/services/statuses.class.php');
require_once(LINK_CONTROLLER . 'rest/services/friends.class.php');

/**
* Gestion des services Rest
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 28/11/2012
* @see Rest
* @namespace gnk\modules\rest
*/
abstract class Services{
	protected $serviceArray = array();
	
	/**
	* Génération du tableau (en fonction de l'API REST)
	* @return array Le tableau généré
	*/
	protected function toArray(){
		$global = Config::getWebsiteConfig();
		if(isset($global['title'])){
			$title = $global['title'];
		}
		else{
			$title = T_('Mon site');
		}
		$this->serviceArray['ltp']['application']=$title;
	}
}

?>