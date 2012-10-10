<?php
	class Select{
		private $select;
		private $from;
		private $where;
		private $join;
		private $order;
		private $limit;
		public function __construct($select, $from){
			if(is_array($select)){
				$this->select=implode(', ', $select);
			}
			else{
				$this->select=$select;
			}
			$this->from=$from;
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
		public function joinLeft($table){
			if(!empty($this->join)){
				$this->join.=' LEFT JOIN '.$table;
			}
			else{
				$this->join='LEFT JOIN '.$table;
			}
		}
		public function on($firstTable, $first, $secondTable, $second, $op='='){
			$this->join.=' ON '.$firstTable.'.'.$first.$op.$secondTable.'.'.$second;
		}
		public function orderBy($table, $value, $order='ASC'){
			$this->orderBy[]=$table . '.'. $value .' ' . $order;
		}
		public function limit($start, $number){
			$this->limit=$start.', '.$number;
		}
		private function getRequest(){
			$sql='SELECT '.$this->select.' FROM '.$this->from;
			if(isset($this->join) AND $this->join != ''){
				$sql.=' '.$this->join;
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
		public function getArray(){
			$request = mysql_query($this->getRequest());
			$array = array();
			while($element = mysql_fetch_array($request)){
				$array[] = $element;
			}
			return $array;
		}
	}
?>