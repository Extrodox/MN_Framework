<?php
class MN_Logic_Loader{
	private $classNames=array();
	private $objects=array();
	private $view;
	public function __construct(){
		$this->addClass('Logic_Boot');
		$this->addClass('Pages_'.ucfirst(PAGE_MAIN).'_Logic_Pre');
		$this->addClass('Pages_'.ucfirst(PAGE_MAIN).'_Logic_'.ucfirst(PAGE_SUB));
		$this->addClass('Pages_'.ucfirst(PAGE_MAIN).'_Logic_Post');
	}
	public function addClass($className){
		$this->classNames[]=$className;
	}
	public function runAll(){
		foreach ($this->classNames as $class) {
			$o=new $class();
			$this->objects[]=$o;
			$o->run();
		}
		
	}
	public function makeViewVars($logic){
		if($logic instanceof MN_Logic_Abstract && $logic->view instanceof stdClass){
			foreach ($logic->view as $key=>$name) {
				$this->view->$key=$name;
			}
		}
		
		
	}
}