<?php
class MN_Db_Query{
	
	const SELECT='0';
	
	const INSERT='1';
	
	const UPDATE='2';	
	
	const DELETE='3';

	private $type;

	private $query="";

	public $condition="";


	public $countCondition="";

	public function insert($table){
		$this->type=self::INSERT;
		$this->query="INSERT INTO $table ";
		return $this;
	}
	public function update($arrayTbl){
		$this->type=self::UPDATE;
		$table=$this->implode(",", $arrayTbl);
		$this->query="UPDATE $table ";
		return $this;
	}
	public function delete(){
		$this->query='DELETE ';
		return $this;
	}

	public function select($arrayCol='*'){
		$columns="*";
		if($arrayCol!='*'){
			$columns=$this->implode(",", $arrayCol);
		}
		
		$this->query="SELECT $columns ";
		return $this;
	}
	private function implode($glue,$variable){
		$list=array();
		foreach ($variable as $key => $value) {
			if(is_string($key)){
				$list[]="$value AS $key";
			}else{
				$list[]="$value";
			}
		}
		return implode($glue, $list);
	}
	public function from($arrayTbl){
		$table=implode(",", $arrayTbl);
		$this->query.=" FROM $table";
		return $this;
	}
	public function order($arrayCol,$desc=false){
		$col=array();
		foreach ($arrayCol as $value) {
			$col[]=implode(" ", $value);
		}
		$col=implode(",", $col);
		$this->query.=" ORDER BY $col";
		if($desc){
			$this->query.=" DESC";
		}
		
		return $this;
	}
	public function limit($offset,$size=null){
		if(!is_null($size)){
			$offset=",$size";
		}
		
		$this->query.=" LIMIT $offset";
		return $this;
	}
	public function data($arrayColVal){
		if($this->type==self::UPDATE){
			$data=array();
			foreach ($arrayColVal as $key => $value) {
				$data[]="{$key}={$this->escape($value)}";
			}
			$data=implode(",", $data);
			$this->query.=" SET $data ";
		}elseif($this->type==self::INSERT){
			$col=array();
			$val=array();
			foreach ($arrayColVal as $key => $value) {
				$col[]=$key;
				$val[]=$this->escape($value);
			}

			$data='('.implode(",", $col).') VALUES ('.implode(",", $val).')';
			$this->query.=" $data ";
		}
		return $this;
	}
	public function join($table,$condition){
		$key=key($table);
		if($key!=0){
			$table=$table[$key]." AS $key";
		}
		$this->query.=" JOIN $table ON $condition ";
		return $this;
	}
	public function where($condition,$value){
		
		return $this->addwhere('AND',$condition,$value);
		
	}
	public function orWhere($condition,$value){

		return $this->addwhere('OR',$condition,$value);
	}
	private function addwhere($type,$condition,$value){
		$value=$this->escape($value);
		$condition=str_replace("?", $value, $condition);
		
		if($this->condition!=""){
			$condition=" $type $condition ";
		}else{
			$condition=" WHERE $condition ";
		}
		$this->condition=$type;
		$this->query.=" $condition ";
		return $this;
	}
	private function escape($val){
		if(is_string($val)){
			$val="'$val'";
		}
		return $val;
	}
	public function __toString(){
		return $this->query;
	}
	public function toQuery(){
		return $this->query;	
	}	
	public function toCountQuery(){

		return $this->query;	
	}	
}