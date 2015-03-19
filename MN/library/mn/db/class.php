<?php
class MN_Db_Class{
	protected $config;
	protected $result=null;
	protected $conn=null;
	protected static $connPool=array();
	public function __construct($config=null){
		$this->config=new MN_Db_Config($config);
		$this->conn=self::findConnection($this->config);
	}
	public static function findConnection($config){
			foreach(self::$connPool as $cnn){
				if($cnn['config']->isEquals($config)){
					return $cnn['pdo'];
					break;
				}
			}
		
			$temp=new PDO(
				$config->getDSN(),
				$config->getUser(),
				$config->getPassword()
			);
			self::$connPool[]=array(
				'config'=>$config,
				'pdo'=>$temp
				);
			return $temp;	

			
	}
	public function __call($name, $arguments){
		return call_user_func_array(array($this->conn, $name), $arguments);		
	}
	public static function __callStatic($name, $arguments){
    	return forward_static_call_array(array('PDO', $name), $arguments);
    }
}