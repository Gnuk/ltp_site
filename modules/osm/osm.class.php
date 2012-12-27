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
use \gnk\config\Module;
use \gnk\config\Page;
/**
* Module générant une map OSM via php
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 08/10/2012
* @see L'api OpenLayer
* @namespace gnk\modules\osm
*/
require_once(Module::getLink('osm') . 'marker.class.php');
class Osm{
	private $divName;
	private $marker = array();
	private $defaultLon;
	private $defaultLat;
	private $defaultZoom;
	private static $loadRequired = false;
	private $picker;
	
	/**
	* Constructeur
	* @param string $divName Nom de la div dans laquelle est affichée la map
	* @param int $lon La longitude par défaut
	* @param int $lon La latitude par défaut
	* @param int $zoom Le zoom par défaut
	*/
	public function __construct($divName='mod_osm_map', $lon = 5.8714950, $lat = 45.6, $zoom = 11){
		$this->divName = $divName;
		$this->defaultLon = $lon;
		$this->defaultLat = $lat;
		$this->defaultZoom = $zoom;
		Osm::loadRequired();
		Page::addCSS(Module::getRLink('osm') . 'css/popup.css');
		Page::addCSS(Module::getRLink('osm') . 'css/default.css');
	}
	
	/**
	* Ajout de calque de type Marker
	* @param Marker $marker L'objet marqueur à ajouter
	* @see \module\osm\Marker
	*/
	public function addMarker($marker){
		$this->marker[]=$marker;
	}
	
	private static function loadRequired(){
		if(!self::$loadRequired){
			Page::setJS(array(
				LINKR_LIB . 'openlayers/OpenLayers.js',
				Module::getRLink('osm') . 'js/OpenStreetMap.js'
			));
			self::$loadRequired = true;
		}
	}
	
	/**
	* Affiche la zone de carte
	*/
	public function showDiv($width=null, $height=null){
?>
	<div id="<?php echo $this->divName;?>" class="mod_otm_map"<?php
	if(isset($width) AND isset($height)){
		?> style=" width:<?php echo $width;?>px; height:<?php echo $height;?>px;"<?php 
	}
		?>><noscript><p><?php echo T_('Veuillez activer javascript pour voir la carte');?></p></noscript></div>
<?php
	}
	
	public function addPicker($formLon = 'longitude', $formLat = 'latitude'){
		$this->picker = '
		var locationPickerLayer = new OpenLayers.Layer.Vector("'.T_('Sélecteur de localisation').'");
        map.addLayer(locationPickerLayer);
    	
        var proj4326 = new OpenLayers.Projection("EPSG:4326");
        var projmerc = new OpenLayers.Projection("EPSG:900913");
        
        var locationPickerPoint = new OpenLayers.Geometry.Point(center.lon, center.lat);
        document.getElementById("'.$formLat.'").value = dlat;
		document.getElementById("'.$formLon.'").value = dlon;
        var locationPickerMarkerStyle = {externalGraphic: \''.Page::rewriteLink(Module::getRLink('osm') . 'images/poi.png').'\', graphicHeight: 37, graphicWidth: 32, graphicYOffset: -37, graphicXOffset: -16 };
        var locationPickerVector = new OpenLayers.Feature.Vector(locationPickerPoint, null, locationPickerMarkerStyle);
        locationPickerLayer.addFeatures(locationPickerVector);
        
        var dragFeature = new OpenLayers.Control.DragFeature(locationPickerLayer, 
				{ 
        			onComplete:	function( feature, pixel ) {
        				var selectedPositionAsMercator = new OpenLayers.LonLat(locationPickerPoint.x, locationPickerPoint.y);
        			 	var selectedPositionAsLonLat = selectedPositionAsMercator.transform(projmerc, proj4326);
        				
        				document.getElementById("'.$formLat.'").value = selectedPositionAsLonLat.lat;
        		    	document.getElementById("'.$formLon.'").value = selectedPositionAsLonLat.lon;
        				
        			}
   				}
        );
        map.addControl(dragFeature);
        dragFeature.activate();
		';
	}
	
	/**
	* Ajoute le JS à la page
	*/
	public function setJS($longitude = null, $latitude = null){
		Page::addJS($this->getJS($longitude, $latitude), true);
	}
	
	/**
	* Récupère le code javascript de la carte
	* @param int $longitude La longitude à centrer
	* @param int $latitude La latitude à centrer
	*/
	public function getJS($longitude = null, $latitude = null){
		if(!isset($longitude)){
			$longitude = $this->defaultLon;
		}
		if(!isset($latitude)){
			$latitude = $this->defaultLat;
		}
		$js='
		function haveMap(dlon, dlat){
		var options = {
			controls: [
			new OpenLayers.Control.Navigation(),
			new OpenLayers.Control.PanZoomBar(),
			new OpenLayers.Control.LayerSwitcher(),
			new OpenLayers.Control.Attribution()
			]
		};
		map = new OpenLayers.Map("'.$this->divName.'", options);
		map.addLayer(new OpenLayers.Layer.OSM.Mapnik("Standard"));
		map.addLayer(new OpenLayers.Layer.OSM.CycleMap("Cyclable"));
		map.addLayer(new OpenLayers.Layer.OSM.TransportMap("Transport"));
		AutoSizeAnchored = OpenLayers.Class(OpenLayers.Popup.Anchored, { \'autoSize\': true});
		
		var center = new OpenLayers.LonLat(dlon, dlat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
		var zoom='. $this->defaultZoom.';
		';
		foreach($this->marker AS $number => $marker){
			$js .= $marker->get();
		}
		if(isset($this->picker)){
			$js .= $this->picker;
		}
		$js.= '
		function addMarker(ll, popupClass, popupContentHTML, closeBox, overflow) {
			var feature = new OpenLayers.Feature(markers, ll); 
			feature.closeBox = closeBox;
			feature.popupClass = popupClass;
			feature.data.popupContentHTML = popupContentHTML;
			feature.data.overflow = (overflow) ? "auto" : "hidden";
					
			var marker = feature.createMarker();

			var markerClick = function (evt) {
				if (this.popup == null) {
					this.popup = this.createPopup(this.closeBox);
					map.addPopup(this.popup);
					this.popup.show();
				} else {
					this.popup.toggle();
				}
				currentPopup = this.popup;
				OpenLayers.Event.stop(evt);
			};
			marker.events.register("mousedown", feature, markerClick);

			markers.addMarker(marker);
		}';
		if(!empty($this->marker)){
			$js.= '
			var bounds = markers.getDataExtent();
			map.zoomToExtent(bounds);';
		}
		else{
			$js .= '
			map.setCenter (center, zoom);';
		}
		$js .= '
		}
		
		function successCallback(position){
			haveMap(position.coords.longitude , position.coords.latitude);
		}; 
		
		function errorCallback(error){
			haveMap('. $this->defaultLon . ', ' . $this->defaultLat .');
		};
		
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {enableHighAccuracy : true, timeout:10000, maximumAge:600000});
		}
		else {
			haveMap('. $this->defaultLon . ', ' . $this->defaultLat .');
		}
		';
		return $js;
	}
	
	/**
	* Affiche le script de la carte
	*/
	public function showJS(){
?>
<script>
<?php
		echo $this->getJS();
?>
</script>
<?php
	}
}
?>