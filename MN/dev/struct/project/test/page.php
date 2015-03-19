<?php
class Page{
	private $path;
	public function __construct(){
		$this->path=$_SERVER['SCRIPT_NAME'];
	}
	public function setRequestUri($request_uri){
		$this->path=$request_uri;
	}
	public function getPageName(){
		
	}
}
var_dump($_SERVER);