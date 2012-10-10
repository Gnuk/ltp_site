<?php
	class Element{
		protected $elem;
		protected $type;
		protected $nbType;
		protected $null=true;
		protected $default;
		protected $encode;
		protected $auto_increment=false;
		
		protected function __construct($name, $type, $nbType=''){
			$this->elem=$name;
			$this->type=$type;
			if(isset($nbType) AND $nbType != ''){
				$this->nbType=$nbType;
			}
		}
		
		protected function setNbType($nbType){
			$this->nbType=$nbType;
		}
		
		protected function setNUll($null){
			$this->null=$null;
		}
		
		protected function setDefault($default){
			$this->default=$default;
		}
		
		protected function setEncode($encode){
			$this->encode=$encode;
		}
		protected function setAutoIncrement($auto_increment){
			$this->auto_increment=$auto_increment;
		}
	}
?>