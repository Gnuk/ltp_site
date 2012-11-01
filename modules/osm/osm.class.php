<?php
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
	
	/**
	* Ajoute le JS à la page
	*/
	public function setJS(){
		Page::addJS($this->getJS(), true);
	}
	
	/**
	* Récupère le code javascript de la carte
	*/
	public function getJS(){
		$js='
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
			return new OpenLayers.Icon(\''. LINKR_IMAGES . 'marker.png\',size,offset);
		}
		map = new OpenLayers.Map("'.$this->divName.'", options);
		map.addLayer(new OpenLayers.Layer.OSM.Mapnik("Standard"));
		map.addLayer(new OpenLayers.Layer.OSM.CycleMap("Cyclable"));
		map.addLayer(new OpenLayers.Layer.OSM.TransportMap("Transport"));
		AutoSizeAnchored = OpenLayers.Class(OpenLayers.Popup.Anchored, { \'autoSize\': true});';
		foreach($this->marker AS $number => $marker){
			$js .= $marker->get();
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
			var center = new OpenLayers.LonLat('. $this->defaultLon . ', ' . $this->defaultLat .').transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
			var zoom='. $this->defaultZoom.';
			map.setCenter (center, zoom);';
		}
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