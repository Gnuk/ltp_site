<?php
namespace gnk\modules\osm;
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
	public function add($lon, $lat, $html=null){
		$marker['lon'] = $lon;
		$marker['lat'] = $lat;
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
				$js.='
				addMarker(new OpenLayers.LonLat('.$marker['lon'] . ',' . $marker['lat'].').transform(
				new OpenLayers.Projection("EPSG:4326"), 
				map.getProjectionObject() 
				), AutoSizeAnchored, \'';
				if(isset($marker['html'])){
					$js.= $marker['html'];
				}
			$js .= '\')';
			}
			else{
				$js.= 'position = new OpenLayers.LonLat('. $marker['lon'] . ',' . $marker['lat'].').transform(
				new OpenLayers.Projection("EPSG:4326"), 
				map.getProjectionObject()
				);
				markers.addMarker(new OpenLayers.Marker(position));';
			}
 		}
 		return $js;
	}
}
?>