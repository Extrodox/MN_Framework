<?php
class MN_Data_Email{
	public $email;
	private $regExp="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$^";

	public function __construct($email){
		$this->email=trim($email);
	}
	public function isValid(){
		return preg_match($this->regExp, $this->email);
	}
}
?>