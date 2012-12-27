<?php
/*
*
* Copyright (c) 2012 GNKW
*
* This file is part of GNK Website.
*
* GNK Website is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* GNK Website is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with GNK Website.  If not, see <http://www.gnu.org/licenses/>.
*/
namespace gnk\config;
/**
* Gestion des modules
* @author Anthony Rey <anthony.rey@mailoo.org>
* @namespace gnk\config
*/
class Module{
	public static function load($moduleName){
		require_once(LINK_MODULES . $moduleName . '/' . $moduleName . '.class.php');
	}
	public static function getLink($moduleName){
		return LINK_MODULES . $moduleName . '/';
	}
	public static function getRLink($moduleName){
		return LINKR_MODULES . $moduleName . '/';
	}
}
?>