<?php
namespace module\osm;
/**
* Module créant une marker OSM via php
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 08/10/2012
* @see Osm
* @namespace module\osm
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
	public function show(){
?>
	markers = new OpenLayers.Layer.Markers("<?php echo $this->alias; ?>");
	map.addLayer(markers);
<?php
 		foreach($this->marker as $number => $marker){
			if(isset($marker['html'])){

?>	addMarker(new OpenLayers.LonLat(<?php echo $marker['lon'] . ',' . $marker['lat'];?>).transform(
		new OpenLayers.Projection("EPSG:4326"), 
		map.getProjectionObject() 
	), AutoSizeAnchored, '<?php
				if(isset($marker['html'])){
?><?php echo $marker['html']; ?><?php
				}
?>');
<?php
			}
			else{
?>
	position = new OpenLayers.LonLat(<?php echo $marker['lon'] . ',' . $marker['lat'];?>).transform(
		new OpenLayers.Projection("EPSG:4326"), 
		map.getProjectionObject()
	);
	markers.addMarker(new OpenLayers.Marker(position));
<?php
			}
 		}
	}
}
?>