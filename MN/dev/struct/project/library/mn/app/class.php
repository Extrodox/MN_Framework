<?php
class MN_App_Class{
	public function run(){
		$this->runChain();
	}
	public function runChain(){
		$chain=MN_App_chain::factory();
		$chain->run();
	}
}