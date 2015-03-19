<?php
class MN_App_Chain{
	private static $object;
	private $path;
	private $config;

	private function loadPath(){
		$this->path=MN_Autocontroller_Path::factory();

		$this->path->makeNames();
		

	}
	private function loadConfig(){
		
		$this->config=MN_Config_Class::getParams($this->path->page);
		$this->path->fixNames();
		
	}
	
	private function __construct(){
		$this->loadPath();
		$this->loadConfig();
	}

	public static function factory(){
		if(!(MN_App_Chain::$object instanceof MN_App_Chain)){
			MN_App_Chain::$object=new MN_App_Chain();
		}
		return MN_App_Chain::$object;
	}

	public function run(){
		$this->makeNamespaces();
		$this->runLogic();
		$this->combineView();
	}
	
	private function makeNamespaces(){
		$n=MN_Namespaces_Class::factory();
		$n->addNamespace('Logic','logic');
		$n->addNamespace('Pages','pages');
		$n->addNamespace('View','library'.DS.'mn'.DS.'view'.DS.'short');
		$n->addNamespace('Debug','library'.DS.'mn'.DS.'debug'.DS.'short');
		$n->addNamespace('Sections','sections');
		$n->addNamespace('LGD','library'.DS.'lgd');
		$n->addNamespace('FB','library'.DS.'fb');
	}

	private function runLogic(){
		$logic=new MN_Logic_Loader();
		$logic->runAll();
	}

	private function combineView(){
		$view=View::factory();
		$view->deployView();
	}
	
}