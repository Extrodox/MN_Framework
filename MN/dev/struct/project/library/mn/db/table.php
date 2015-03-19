<?php
class MN_Db_Table extends MN_Db_Class{
	protected $___tableName;
	protected $___primaryKey;
	public $___query;
	private $___statment;
	private $___conditions=array();
	private $___config;
	private $___columns;
	
	public function __construct($tableName,$config=null){

		parent::__construct($config);

		$this->___config=$config;
		$this->___tableName=$tableName;
		$this->___primaryKey='id';
		$this->___query=new MN_Db_Query();

		
		/*$dbName=$this->___config['name'];
		$q = $this->prepare("SELECT 
      ke.column_name col, 
      ke.referenced_table_schema assoc_db,
      ke.referenced_table_name assoc_table,
      ke.referenced_column_name assoc_col
FROM
      information_schema.KEY_COLUMN_USAGE ke
WHERE
      ke.referenced_table_name IS NOT NULL              
AND   ke.table_schema='{$dbName}'
AND   ke.table_name='{$this->___tableName}'");
		$q->execute();
*/
	
		$q = $this->prepare("DESCRIBE {$this->___tableName}");
		$q->execute();
		$this->___columns= $q->fetchAll(PDO::FETCH_OBJ);
	}

	public function setPrimaryKey($colName){
		$this->___primaryKey=$colName;
	}

	public function getTableName(){
		return $this->___tableName;
	}

	public function load($id=null){
		if(!is_null($id)){
			$this->addAttribute($this->___primaryKey,$id);
		}

		$x=$this->getQueryString();
		$this->___statment=$this->query($x);
		return $this->fetchObj();
	}
	private function fetchObj(){
		
		$objs=$this->___statment->fetchAll(PDO::FETCH_OBJ);
		$rows=array();
		foreach ($objs as $obj) {
			$rows[]=new MN_Db_Row($obj,$this->___primaryKey,$this->___tableName,$this->___config);
		}
		//return count($rows)==1?$rows[0]:$rows;
		return $rows;
	}
	public function limit($offset,$size=null){
		$this->___query->limit($offset,$size);
		return $this;
	}
	public function order($arrayCol,$desc=false){
		$this->___query->order($arrayCol,$desc);
		return $this;
	}
	public function getQueryString(){
		
		$this->___query->select()->from(array($this->___tableName));
		
		foreach ($this->___conditions as $con) {
			$this->___query->where($con[0],$con[1]);
		}
		return  $this->___query->toQuery();
		
	}
	public function addAttribute($attribute,$value=null){
		$this->___conditions[]=array("$attribute = ?",$value);
		
		return $this;
	}

	public function addCondition($condition,$value=null){
		$this->___conditions[]=array($condition,$value);
		
		return $this;
	}
	public function newRow(){
		$obj=new stdClass();
		foreach ($this->___columns as $col) {
			$obj->{$col->Field}=null;
		}
		
		return new MN_Db_Row($obj,$this->___primaryKey,$this->___tableName,$this->___config);
	}
	public function loadCount($id=null){
		
		if(!is_null($id)){
			$this->addAttribute($this->___primaryKey,$id);
		}

		$this->___countQuery=new MN_Db_Query();
		$this->___countQuery->select(array("COUNT('*') as `count`"))->from(array($this->___tableName));
		
		foreach ($this->___conditions as $con) {
			$this->___countQuery->where($con[0],$con[1]);
		}

		$x=$this->___countQuery->toQuery();
		$this->___countStatment=$this->query($x);
		$objs=$this->___countStatment->fetchAll(PDO::FETCH_OBJ);
		
		return intval($objs[0]->count);

	}

}