<?php
class MN_Namespaces_Class{
	private $namespaces=array();
	private static $object;
	private $defaultPath;
	private function __construct(){
		$this->defaultPath=AP."library";
	}
	public static function factory(){

		if(!(MN_Namespaces_Class::$object instanceof MN_Namespaces_Class)){
			MN_Namespaces_Class::$object=new MN_Namespaces_Class();
		}
		return MN_Namespaces_Class::$object;
	}
	public function addNamespace($name,$path){
		$path=strtolower($path);
		$this->namespaces[$name]=$path;
	}
	public function getPath($name){
		return isset($this->namespaces[$name])?
			$this->namespaces[$name]:
			$this->defaultPath.DS.strtolower($name);
	}
	public function setDefaultPath($path){
		$this->defaultPath=$path;
	}
}
