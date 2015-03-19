<?php
class MN_View_Class{
	private static $object;
	public $layout;
	private $fileIndex=0;
	private $classNames=array();
	private function __construct(){
		$this->classNames['section']="MN_Section_Class";
		$this->layout=MN_View_Layout::factory();
	}
	public static function factory(){
		if(!(self::$object instanceof self)){
			self::$object=new self();
		}
		return self::$object;
	}
	public function deployFile(){
		$file=$this->layout->files[$this->fileIndex++];
		include $file;
	}
	public function deployView(){
		$this->layout->makeViewFilePaths();
		$this->deployFile();
	}
	public function content(){
		$this->deployFile();	
	}
	
	public function __call($name, $arguments)
    {    	

    	try{
    		$names=explode("_",$name);
	    	if($names[0]=="get" && count($names)<4 ){
	    		MN_Section_Class::getSectionByName(isset($names[2])?$names[2]:null,$arguments);
	    	}else{
	    		throw new Exception("$name is not a valid function valid names are as followings",1);
	    	}	

    	}catch(Exception $e){
    		Debug::label($e->getMessage());
    		$validNames=array();
    		foreach($classNames as $key=>$value){
    			$sections=MN_Section_Class::getAllNames();
    			foreach($sections as $section){
    				$validNames[$key][]="get_{$key}_$section()";
    			}
    		}
    		Debug::show($validNames);
    	}
    	
    	
        
    }

}