<?php
class MN_Autocontroller_Path{
	private $path;
	private $seotoken="";
	public $page=null;
	public $subPage=null;
	public static $object;
	private function __construct(){
		$this->path=isset($_SERVER['REDIRECT_SCRIPT_URL'])?$_SERVER['REDIRECT_SCRIPT_URL']:
		(isset($_SERVER['REDIRECT_URL'])?$_SERVER['REDIRECT_URL']:"/");
	}
	public function getPath(){
		return $this->path;
	}
	public static function factory(){
		if(!(self::$object instanceof self)){
			self::$object=new self();
		}
		return self::$object;
	}
	public function setRequestUri($request_uri){
		$this->path=$request_uri;
	}
	public function setNames($page=null,$subPage=null){
		$this->page=$page;
		$this->subPage=$subPage;
	}
	public function fixNames(){
		
		if(is_null($this->page)){
			$this->page=defined('PAGE_MAIN_DEFAULT')?PAGE_MAIN_DEFAULT:$this->page;

		}
		
		if(is_null($this->subPage)){
			$this->subPage=defined('PAGE_SUB_DEFAULT')?PAGE_SUB_DEFAULT:$this->subPage;
		}

		define('PAGE_MAIN',$this->page);
		define('PAGE_SUB',$this->subPage);

	}
	public function makeNames(){
		
		if($this->path!="/"){
			preg_match("/^\/+([^\/]+)/", 
			$this->path,
			$matches,
			PREG_OFFSET_CAPTURE);
		
			$this->page=isset($matches[1][0])?($matches[1][0]):null;

			preg_match("/^\/+[^\/]+\/+([^\/]*)/", 
				$this->path,
				$matches,
				PREG_OFFSET_CAPTURE);
			$this->subPage=isset($matches[1][0]) && $matches[1][0]!=$this->seotoken?($matches[1][0]):null;
		}

		if($this->page!=null && !is_dir("pages".DS.$this->page)){
			
			$this->page=PAGE_NOT_FOUND;
	
		}
		if($this->subPage!=null && !file_exists("pages".DS.$this->page.DS."group".DS.$this->subPage.".php")){
			$this->subPage="index";
			//echo 11;
		}

	}
}