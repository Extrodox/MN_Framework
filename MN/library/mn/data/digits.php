<?php
class MN_Data_Digits{
	private $digits;
	public function __construct($digits){
		$this->digits=trim($digits);
	}
	public function isValid(){
		return is_numeric($this->digits);
	}
}
?>