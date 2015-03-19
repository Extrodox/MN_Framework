<?php
class MN_Logic_Form extends MN_Logic_Section{

	private $__elements=array('input','textarea','select');
	private $__classlist=array('required','email','digits','url');
	private $xml;
	private $__method=null;
	private $elements=array();
	private $nameRegExp="/^[a-zA-Z0-9]*$/";
	public $value;
	private $init=false;
	public function run(){

	}
	public function init(){

		if(!$this->init){

			$this->xml = new DOMDocument();
			@$this->xml->loadHTMLFile($this->getViewFilePath()); //return DOMObject
	 		
			$this->value=$this->getFormData();
			
			$this->init=true;
		}
	}
	public function isSubmitted(){
		$this->init();
		$this->value=$this->getFormData();
		return count($this->value)>0;
	}

	public function isValid(){
		
		$this->init();

		$this->getClassandValues();
		
		return $this->validateElements();

	}

	private function validateElements(){
		$x=true;
		foreach ($this->elements as  $name=>$e) {
			$classes=explode(" ",$e['class']);
			foreach ($classes as $class) {
				if(in_array($class, $this->__classlist)){
					$validatorClass="MN_Data_".ucfirst($class);
					@$t=new $validatorClass($e['value']);
					if($t->isValid()){
						$x=$x && true;
					}else{
						$this->elements[$name]['error']="Enter Valid $class value for $name.";
						$x=$x && false;
					}
				}
				
			}
		}
		return $x;
	}

	private function getClassandValues(){
		foreach ($this->__elements as $e) {
		    foreach($this->xml->getElementsByTagName($e) as $elem){

		    	$name=$elem->getAttribute('name');
				$class=$elem->getAttribute('class');
				if($class!=''){
					@$this->elements[$name]=array(
						'class'=>$class,
						'value'=>$this->value[$name]
					);	
				}
				
			}
		}

	}

	private function getFormData(){
		switch ($this->getMethod()) {
			case 'post':
				return $_POST;
				break;
			default:
				return $_GET;
				break;
		}
	}
	public function getMethod(){
		if(is_null($this->__method)){
			$forms=$this->xml->getElementsByTagName('form');
			
			foreach ($forms as $form) {
				$m=$form->getAttribute('method');				
				$this->__method= ($m!='')?trim($m):'get';
			}
		}
		return $this->__method; // return string post		
	}
	public function getErrors(){
		$r=array();
		foreach ($this->elements as $name=>$e) {
			if(isset($e['error'])){
				$r[]=$e['error'];
			}
		}

		return $r;
	}
}