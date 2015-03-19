<?php
abstract class MN_Logic_Section extends MN_Logic_Abstract{
	private $page;
	private $section;

	public function __construct($args=null){
		parent::__construct();
		$class=get_class($this);
		preg_match("/(Pages_){0,1}([a-zA-Z0-9]*)_{0,1}Sections_([a-zA-Z0-9]*)_Logic/",$class,$match);		
		$this->section=strtolower($match[3]);

		if(count($args)<1 || is_null($args) || (isset($args[0]) && $args[0]===true)){

			$this->page=strtolower($match[2]);

		}else if(isset($args[0]) && is_string($args[0])){

			$this->page=strtolower($args[0]);

		}else if(isset($args[0]) && $args[0]===false){

			$this->page='';

		}	
	}

	protected function getViewFilePath(){

		if($this->page==""){
			return AP.'sections'.DS.$this->section.DS.'view.php';
		}else{
			return AP.'pages'.DS.$this->page.DS.'sections'.DS.$this->section.DS.'view.php';
		}

	}
	public function deploySection(){
		$this->run();
		include $this->getViewFilePath();
	}

}
