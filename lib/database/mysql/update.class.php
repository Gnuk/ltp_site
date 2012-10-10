<?php
	class Update{
		private $elems;
		private $table;
		private $where;
		private $limit;
		private $orderBy;
		public function __construct($table, $elems){
			$this->table = $table;
			$alterne = true;
			$nbChp=0;
			$nbVal=0;
			foreach($elems as $key => $element){
				if($alterne){
					$champ[]=$element;
					$nbChp++;
					$alterne=false;
				}
				else{
					$value[]=$element;
					$nbVal++;
					$alterne=true;
				}
			}
			if($nbVal == $nbChp){
				for($i=0; $i<$nbVal; $i++){
					$this->elems[]=$champ[$i].'='.mysql_real_escape_string($value[$i]);
				}
			}
		}
		public function whereAnd($first, $second, $op='='){
			if(!empty($this->where)){
				$this->where.=' AND '.$first.' '.$op.' '.$second;
			}
			else{
				$this->where='WHERE '.$first.' '.$op.' '.$second;
			}
		}
		public function whereOr($first, $second, $op='='){
			if(!empty($this->where)){
				$this->where.=' OR '.$first.' '.$op.' '.$second;
			}
			else{
				$this->where='WHERE '.$first.' '.$op.' '.$second;
			}
		}
		public function whereStart($first, $second, $op='=', $association='AND'){
			if(!empty($this->where)){
				$this->where.=' '.$association.' ('.$first.$op.$second;
			}
			else{
				$this->where='WHERE ('.$first.$op.$second;
			}
		}
		public function whereEnd(){
			$this->where.=')';
		}
		public static function toTable($table, $value){
			return $table.'.'.$value;
		}
		public static function toString($value){
			return '\''.$value.'\'';
		}
		public function orderBy($table, $value, $order='ASC'){
			$this->orderBy[]=$table . '.'. $value .' ' . $order;
		}
		public function limit($start, $number){
			$this->limit=$start.', '.$number;
		}
		private function getRequest(){
			$sql='UPDATE '.$this->table;
			if(isset($this->elems) AND $this->elems != ''){
				$sql.=' SET ';
				$sql.=implode(', ', $this->elems);
			}
			if(isset($this->where) AND $this->where != ''){
				$sql.= ' '.$this->where;
			}
			if(isset($this->orderBy) AND is_array($this->orderBy)){
				$sql .= ' ORDER BY ';
				$sql .= implode(', ', $this->orderBy);
			}
			if(isset($this->limit) AND $this->limit != ''){
				$sql .= ' LIMIT '.$this->limit;
			}
			return $sql;
		}
		public function apply(){
			mysql_query($this->getRequest());
		}
	}
?>