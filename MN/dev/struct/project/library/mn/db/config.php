<?php
class MN_Db_Config{
	private $host;
	private $user;
	private $password;
	private $name;
	private $type;

	public function __construct($array=null){
		$this->type=isset($array['type'])?$array['type']:(defined('DB_TYPE')?DB_TYPE:'mysql');
		$this->host=isset($array['host'])?$array['host']:(defined('DB_HOST')?DB_HOST:'localhost');
		$this->user=isset($array['user'])?$array['user']:defined('DB_USER')?DB_USER:'root';
		$this->name=isset($array['name'])?$array['name']:(defined('DB_NAME')?DB_NAME:'');
		$this->password=isset($array['password'])?$array['password']:defined('DB_PASSWORD')?DB_PASSWORD:'';
	}

	public function setHost($host){
		$this->host=$host;
	}
	public function getHost(){
		return $host;
	}
	public function setUser($user){
		$this->user=$user;
	}
	public function getUser(){
		return $this->user;
	}
	public function setPassword($password){
		$this->password=$password;
	}
	public function getPassword(){
		return $this->password;
	}
	public function getName(){
		return $this->name;
	}
	public function getDSN(){
		return "{$this->type}:host={$this->host};dbname={$this->name}";
	}
	public function isEquals($config){
	if( $this->host==$config->host &&
		$this->user==$config->user && 
		$this->password==$config->password &&
		$this->name==$config->name &&
		$this->type==$config->type ){
		return true;
	}
	return false;

	}

}