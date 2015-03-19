<?php
class MN_Data_Required{
	private $value;
	public function __construct($value){
		$this->value=trim($value);
	}
	public function isValid(){
		return $this->value!=''
			&& !is_null($this->value);
	}
}
?>