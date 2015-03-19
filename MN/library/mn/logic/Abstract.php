<?php
abstract class MN_Logic_Abstract{
	public $view;
	public function __construct(){
		$this->view=View::factory();
		
	}
	public abstract function run();
}