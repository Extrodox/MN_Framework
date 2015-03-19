<?php
class MN_View_Layout{
	private $superLayout;
	private $pageLayout;
	private $defaultLayout;
	public $enabled=true;
	public $files=array();
	private static $object;

	private function run(){

		$this->defaultLayout="layout.php";
		$this->enabled=defined('LAYOUT_ENABLED')?LAYOUT_ENABLED:true;
		$this->enabled=$this->escapeName($this->enabled);
		
		if($this->enabled){
			$this->superLayout=defined('LAYOUT_SUPER')?LAYOUT_SUPER:$this->defaultLayout;
			$this->superLayout=$this->escapeName($this->superLayout);
			$this->pageLayout=defined('LAYOUT_PAGE')?LAYOUT_PAGE:$this->defaultLayout;
			$this->pageLayout=$this->escapeName($this->pageLayout);	
		}

	}
	private function __construct(){
		$this->run();
	}
	public static function factory(){
		if(!(self::$object instanceof self)){
			self::$object=new self();
		}
		return self::$object;
	}
	public function escapeName($string){
		if($string==='false'){
			return 	false;
		}
		return $string;
	}
	
	public function setSuperLayout($filename){
		$this->superLayout=$filename;
	}
	public function setPageLayout($filename){
		$this->pageLayout=$filename;
	}
	public function makeViewFilePaths(){
		if($this->enabled){
			$this->files[]=AP.'layout'.DS.$this->superLayout;
			$this->files[]=AP.'pages'.DS.PAGE_MAIN.DS.'layout'.DS.$this->pageLayout;
		}
		
		$sub=PAGE_SUB;
		if($sub!='index'){
			$sub='group'.DS.PAGE_SUB;
		}
		
		$this->files[]=AP.'pages'.DS.PAGE_MAIN.DS.$sub.".php";
	}
}