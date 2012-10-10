<?php
	/**
	* Gestion des tables
	* @todo Séparer l'extends d'Element
	*/
	class Table extends Element{
		private $name;
		private $element;
		private $primary;
		private $unique;
		private $engine='MyISAM';
		private $charset='utf8';
		private $collate='utf8_unicode_ci';
		
		public function __construct($table){
			$this->name=$table;
		}
		public function addInt($name, $null, $default='', $auto_increment=false){
			$element=new Element($name, 'int', 11);
			$element->setNull($null);
			if(isset($default) AND $default != ''){
				$element->setDefault($default);
			}
			$element->setAutoIncrement($auto_increment);
			$this->element[]=$element;
		}
		public function addVarchar($name, $null, $default=''){
			$element=new Element($name, 'varchar', 255);
			$element->setNull($null);
			$element->setEncode('utf8_unicode_ci');
			if(isset($default) AND $default != ''){
				$element->setDefault($default);
			}
			$this->element[]=$element;
			
		}
		public function addTimestamp($name, $null, $default=''){
			$element=new Element($name, 'timestamp');
			$element->setNull($null);
			if(isset($default) AND $default != ''){
				$element->setDefault($default);
			}
			$this->element[]=$element;
			
		}
		public function addTinyint($name, $null, $default=''){
			$element=new Element($name, 'tinyint', 1);
			$element->setNull($null);
			if(isset($default) AND $default != ''){
				$element->setDefault($default);
			}
			$this->element[]=$element;
		}
		public function addText($name){
			$element=new Element($name, 'text');
			$element->setEncode('utf8_unicode_ci');
			$element->setNull(false);
			$this->element[]=$element;
		}
		public function setEngine($engine){
			$this->engine=$engine;
		}
		public function addPrimary($key){
			$this->primary[]=$key;
		}
		public function addUnique($key){
			$this->unique[]=$key;
		}
		private function getRequest(){
			$sql='CREATE TABLE IF NOT EXISTS '.$this->name.' (';
			foreach($this->element as $key => $object){
				$contenu=$object->elem;
				$contenu.=' '.$object->type;
				if($object->nbType != NULL AND $object->nbType != ''){
					$contenu .= '('.$object->nbType.')';
				}
				if(isset($object->encode) AND $object->encode != ''){
					$contenu .= ' COLLATE '.$object->encode;
				}
				if(!$object->null){
					$contenu .= ' NOT NULL';
				}
				if(isset($object->default) AND $object->default != ''){
					switch($object->type){
						case 'timestamp':
							if($object->default == 'CURRENT_TIMESTAMP'){
								$reqDefault = $object->default;
							}
							else{
								$reqDefault = '\''.$object->default.'\'';
							}
							break;
						default :
							$reqDefault = '\''.$object->default.'\'';
							break;
					}
					$contenu .= ' DEFAULT '.$reqDefault;
				}
				if($object->auto_increment){
					$contenu .= ' AUTO_INCREMENT';
				}
				$tab[]=$contenu;
			}
			if($this->primary != NULL){
				$contenu = ' PRIMARY KEY (';
				foreach($this->primary as $pKey => $pValue){
					$tabP[]=$pValue; 
				}
				$contenu .= implode(', ', $tabP);
				$contenu .= ' )';
				$tab[] = $contenu;
			}
			if($this->unique != NULL){
				$contenu = ' UNIQUE KEY (';
				foreach($this->unique as $uKey => $uValue){
					$tabU[]=$uValue; 
				}
				$contenu .= implode('), UNIQUE KEY (', $tabU);
				$contenu .= ' )';
				$tab[] = $contenu;
			}
			if(!empty($tab)){
				$sql.=implode(', ', $tab);
			}
			$sql.=')';
			$sql.= ' ENGINE='.$this->engine;
			$sql.=' DEFAULT CHARSET='.$this->charset.' COLLATE='.$this->collate.';';
			return $sql;
		}
		public function apply(){
			mysql_query($this->getRequest());
		}
	}
?>