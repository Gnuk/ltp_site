<?php
/**
* Module générant une map OSM via php
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 08/10/2012
* @see L'api OpenLayer
*/
require_once(Module::getLink('osm') . 'marker.class.php');
class ModOsm{
	private $divName;
	private $marker = array();
	
	public function __construct($divName='mod_osm_map'){
		$this->divName = $divName;
	}
	
	public function addMarker($marker){
		$this->marker[]=$marker;
	}
}
?>