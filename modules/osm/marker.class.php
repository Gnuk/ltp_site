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
namespace gnk\modules\osm;
use \gnk\config\Page;
/**
* Module créant une marker OSM via php
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 08/10/2012
* @see Osm
* @namespace gnk\modules\osm
*/
class Marker{
	private $alias;
	private $marker = array();
	
	/**
	* Constructeur
	* @param string $alias L'alias du layer de marqueurs
	*/
	public function __construct($alias){
		$this->alias=$alias;
	}
	
	/**
	* Ajoute un marqueur
	* @param int $lon La longitude
	* @param int $lat La lattitude
	* @param string $html Le code html à ajouter dans la popup du point
	*/
	public function add($lon = null, $lat = null, $html=null){
		$marker['center'] = false;
		if(isset($lon) AND isset($lat)){
			$marker['lon'] = $lon;
			$marker['lat'] = $lat;
		}
		else{
			$marker['center'] = true;
		}
		if(isset($html)){
			$marker['html'] = $html;
		}
		$this->marker[] = $marker;
	}
	
	/**
	* Affiche le marqueur
	*/
	public function get(){
		$js='
		markers = new OpenLayers.Layer.Markers("' .$this->alias.'");
		map.addLayer(markers);';
 		foreach($this->marker as $number => $marker){
			if(isset($marker['html'])){
				$js .= '
		addMarker(';
			}
			else{
				$js .= 'position = ';
			}
			$js.='
			new OpenLayers.LonLat(';
			if($marker['center']){
				$js .= 'dlon, dlat';
			}
			else{
				$js .= $marker['lon'] . ',' . $marker['lat'];
			}
			$js .= ').transform(
			new OpenLayers.Projection("EPSG:4326"), 
			map.getProjectionObject() 
		)';
			if(isset($marker['html'])){
				$js .= ', AutoSizeAnchored, \'';
				if(isset($marker['html'])){
					$js.= Page::textToOneLine($marker['html']);
				}
			$js .= '\')';
			}
			else{
				$js.= ';
			markers.addMarker(new OpenLayers.Marker(position));';
			}
 		}
 		return $js;
	}
}
?>