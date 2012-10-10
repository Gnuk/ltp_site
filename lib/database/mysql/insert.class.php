<?php
	class Insert{
		private $elems;
		private $table;
		private $values;
		
		public function __construct($table, $elems, $values){
			$this->elems=$elems;
			$this->values=$values;
			$this->table=$table;
		}
		private function getRequest(){
			$requete = 'INSERT INTO '.$this->table.' (';
			$requete.=implode(', ', $this->elems);
			$requete.=')';
			$nbIni=0;
			$nbElems=count($this->elems);
			$lastElem=$nbElems;
			$tabNumber=0;
			foreach($this->values as $key=>$valeurs){
				if($lastElem==$nbIni){
					$tabNumber++;
					$lastElem=$lastElem+$nbElems;
				}
				$tab[$tabNumber][]=$valeurs;
				$nbIni++;
			}
			foreach($tab as $fkey => $fvalue){
				if($fkey==0){
					$requete.= ' VALUES (';
				}
				else{
					$requete.= ',(';
				}
				$requete.=implode(', ', mysql_real_escape_string($fvalue));
				$requete.= ')';
			}
			return $requete;
		}
		public function apply(){
			mysql_query($this->getRequest);
		}
	}
?>