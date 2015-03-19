<?php
class MN_Db_Row extends MN_Db_Class{
	protected $___tableName;
	protected $___primaryKey;
	public $___query;
	private $___statment;
	private $___conditions=array();
	private $___data;
	
	public function __construct($dataObj,$primaryKey,$tableName,$config=null){
		parent::__construct($config);
		$this->___data=$dataObj;
		$this->___tableName=$tableName;
		$this->___primaryKey=$primaryKey;
		$this->___query=new MN_Db_Query();
		foreach($this->___data as $attribute=>$value) {
			$this->$attribute=$value;
		}

	}
	public function save(){
		$changes=$this->getChanges();
		if(!is_null($this->{$this->___primaryKey})){
			
			$query=$this->getUpdateQuery($changes);
		}else{
			$query=$this->getInsertQuery($changes);
		}
		$this->query($query);
	/*	if(!$this->query($update)){
			echo $insert=$this->getInsertQuery($changes);
		}
*/
	}

	private function getChanges(){
		$changes=array();

		foreach ($this->___data as $attribute => $value) {
			//var_dump($attribute,$value);
			if(isset($this->$attribute) && 
				$this->___data->$attribute!=$this->$attribute){
				$changes[$attribute]=$this->$attribute;
			}
		}
		return $changes;
	}
	private function getUpdateQuery($o){
		$this->___query->update(array($this->___tableName))
						->data($o)
						->where("{$this->___primaryKey}=?",$this->{$this->___primaryKey});
		return $this->___query->toQuery();
	}
	private function getInsertQuery($o){
		$this->___query->insert($this->___tableName)
						->data($o);
		return $this->___query->toQuery();
	}

}