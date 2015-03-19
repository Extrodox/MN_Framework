<?php
class MN_Config_Class{
	private static $config=null;
	private $params=array();
	private $appPath=AP;
	private $files=array("global"=>"config/index.ini");
	
	private function definENV(){
		defined('APPLICATION_ENV')
		    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? 
		                                  getenv('APPLICATION_ENV') : 
		                                  'production'));
	}
	private function loadFileData($file){
		$t=parse_ini_file($file,true);
		if(APPLICATION_ENV!='production' 
			&& isset($t[APPLICATION_ENV])){
			$t=array_merge($t['production'],$t[APPLICATION_ENV]);
		}else{
			$t=$t['production'];
		}
		
		return $t;
	}
	private function loadConfig(){
		if(isset($this->files['page'])){
			
			$this->params=array_merge($this->loadFileData($this->files['global']),
									$this->loadFileData($this->files['page']));
		}else{
			$this->params=$this->loadFileData($this->files['global']);
			if(isset($this->params['page.main.default']) && 
				!isset($_SERVER['REDIRECT_URL'])){
				$this->params=array_merge($this->params,
									$this->loadFileData(
										$this->getPageIni($this->params['page.main.default'])
										)
									);
			}
		}

		
	}

	private function makeConstants(){
		foreach($this->params as $param=>$value){
			$param=str_replace(".","_",$param);
			define(strtoupper($param),$value);
		}
		
	}
	private function getPageIni($page){
		return $this->appPath."pages/$page/config.ini";
	}
	private function getGlobalIni(){
		return $this->appPath.$this->files['global'];
	}
	private function __construct($page=null){
		$this->definENV();
		if(!is_null($page)){
			$this->files['page']=$this->getPageIni($page);
		}
		$this->files['global']=$this->getGlobalIni();
		$this->loadConfig();
		$this->makeConstants();
	}

	public static function getParams($page=null){

		if(is_null(MN_Config_Class::$config)){
			$t=new MN_Config_Class($page);
		}else{
			$t=MN_Config_Class::$config;
		}
		return $t->params;
	}

}
