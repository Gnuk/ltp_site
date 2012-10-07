<?php
/**
* Module créant une marker OSM via php
* @author Anthony REY <anthony.rey@mailoo.org>
* @since 08/10/2012
* @see ModOsm
*/
class ModOsmMarker{
	private $name;
	private $alias;
	private $marker = array();
	
	/**
	* Constructeur
	* @param string $name Le nom du layer de marqueurs
	* @param string $name L'alias du layer de marqueurs
	*/
	public function __construct($name, $alias){
		$this->name=$name;
		$this->alias=$alias;
	}
	
	/**
	* Ajoute un marqueur
	* @param int $lon La longitude
	* @param int $lat La lattitude
	* @param string $title Le titre du point
	* @param string $description La description du point
	*/
	public function add($lon, $lat, $title=null, $description=null){
		$this->marker[]['lon'] = $lon;
		$this->marker[]['lat'] = $lat;
		if(isset($title)){
			$this->marker[]['title'] = $title;
		}
		if(isset($title)){
			$this->marker[]['description'] = $description;
		}
	}
	
	/**
	* Affiche le marqueur
	* @todo Implémenter la méthode
	*/
	public function show(){
		# Unimplemented method
	}
}
?>