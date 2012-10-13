<?php
namespace module;
use \gnk\Module;
/**
* Module générant une map OSM via php
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 08/10/2012
* @see L'api OpenLayer
* @namespace module
*/
require_once(Module::getLink('osm') . 'marker.class.php');
class Osm{
	private $divName;
	private $marker = array();
	private $defaultLon;
	private $defaultLat;
	private $defaultZoom;
	
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
	}
	
	/**
	* Ajout de calque de type Marker
	* @param ModOsmMarker $marker L'objet marqueur à ajouter
	* @see ModOsmMarker
	*/
	public function addMarker($marker){
		$this->marker[]=$marker;
	}
	
	/**
	* Affiche le script de la carte
	*/
	public function show(){
?>
<script src="<?php echo LINKR_LIB; ?>openlayers/OpenLayers.js"></script>
<script src="<?php echo Module::getRLink('osm');?>js/OpenStreetMap.js"></script>
<script>
	var options = {
		controls: [
		new OpenLayers.Control.Navigation(),
		new OpenLayers.Control.PanZoomBar(),
		new OpenLayers.Control.LayerSwitcher(),
		new OpenLayers.Control.Attribution()
		]
	};
	function getIcon(){
		var size = new OpenLayers.Size(21, 25);
		var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
		return new OpenLayers.Icon('<?php echo LINKR_IMAGES . 'marker.png';?>',size,offset);
	}
	map = new OpenLayers.Map("<?php echo $this->divName;?>", options);
// 	map.addLayer(new OpenLayers.Layer.OSM("OSM"));
	map.addLayer(new OpenLayers.Layer.OSM.Mapnik("Standard"));
	map.addLayer(new OpenLayers.Layer.OSM.CycleMap("Cyclable"));
	map.addLayer(new OpenLayers.Layer.OSM.TransportMap("Transport"));
	AutoSizeAnchored = OpenLayers.Class(OpenLayers.Popup.Anchored, { 'autoSize': true});
<?php
	foreach($this->marker AS $number => $marker){
		$marker->show();
	}
?>
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
	}
<?php
	if(!empty($this->marker)){
?>
	var bounds = markers.getDataExtent();
	map.zoomToExtent(bounds);
<?php
	}
	else{
?>
	var center = new OpenLayers.LonLat(<?php echo $this->defaultLon . ', ' . $this->defaultLat; ?>).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
	var zoom=<?php echo $this->defaultZoom;?>;
	map.setCenter (center, zoom);
<?php } ?>
</script>
<?php
	}
}
?>