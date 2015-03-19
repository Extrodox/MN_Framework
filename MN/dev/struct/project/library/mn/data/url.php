<?php
class MN_Data_Url{
	private $url;
	private $regExp="/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

	public function __construct($url){
		$this->url=trim($url);
	}
	public function isValid(){
		return preg_match($this->regExp, $this->url);
	}
}
?>