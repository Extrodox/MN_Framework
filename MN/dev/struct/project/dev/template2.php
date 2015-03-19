<?php
define('DS',DIRECTORY_SEPARATOR);
class TemplateMaker{
	public $files;
	public $name;
	public $parent;
	public $type;
	private $nameRegExp="/^[a-zA-Z0-9]*$/";
	public $ap;
	public $path;
	private $isExistsInternal;
	public $report;
	public function __construct($type='section',$pr=false){
		$this->ap="..".DS;
		$this->type=$type;
	}
	public function run(){
		$this->makePath();

		if($this->isValid() && !$this->isExists()){

			$this->createTemplate();
			header("Location:index.php?type={$this->type}&report={$this->type} $this->name is created.");
		}
		else if(!$this->isValid()){
			header("Location:index.php?type={$this->type}&report={$this->name} is an invalid name.");
		}
		else{
			header("Location:index.php?type={$this->type}&report=This {$this->type} {$this->name} is already exists.");
		}
	}

	public function setName($name=null){
		$this->name=$name;
	}

	public function setParent($parent=null){
		$this->parent=$parent;
	}

	public function parentCheck(){
		if($this->parent != null){
			return true; 
		}
		else{
				return false;
			}
	}

	public function isValid(){
		$x=(preg_match($this->nameRegExp, $this->name));
		return $x;
	}

	public function makePath(){

		if($this->parentCheck()){
			if($this->type=='group'){
				$this->path=$this->ap.DS.'Pages'.DS.$this->parent.DS;
			} else {
				$this->path=$this->ap.DS.'Pages'.DS.$this->parent.DS.$this->type.DS;			
			}

		}
		else if($this->type=='project'){
			$this->path='..'.DS.$this->ap.$this->name.DS;

		}
		else if($this->type=='form'){
			$this->path=$this->ap.DS.'sections'.DS;
		}
		else
		{
			$this->path=$this->ap.DS.$this->type.DS;
		}
		
	}

	public function isExists(){
		if($this->type=='project'){
			return (is_dir($this->path));
		} else {
		return (is_dir($this->path.$this->name) || file_exists($this->path.$this->name.'.php'));		
		}

	}

	public function read_all_files($root = '.'){
		$files = array('files'=>array(), 'dirs'=>array());
		$directories = array();
		$last_letter = $root[strlen($root)-1];

		$root = ($last_letter == '\\' || $last_letter == '/') ? $root : $root.DIRECTORY_SEPARATOR;
		$directories[] = $root;

		while (sizeof($directories)) {
			$dir = array_pop($directories);
			if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file == '.' || $file == '..') {
				continue;
		}
		
		$file = $dir.$file;
		if (is_dir($file)) {
			$directory_path = $file.DIRECTORY_SEPARATOR;
			array_push($directories, $directory_path);
			if($this->type=='form'){
				if($this->parentCheck()){
					$this->path=$this->ap.DS.'Pages'.DS.$this->parent.DS.'sections'.DS;
				}
				else{
					$this->path=$this->ap.DS.'sections'.DS;
				}

			}
			if($this->type!="project"){
				$files['dirs'][] = str_replace(array('struct'.DS.$this->type.DS,'name'), array($this->path,$this->name), $directory_path);
			}else{
				$files['dirs'][] = str_replace('struct'.DS.$this->type.DS, $this->path, $directory_path);

			}

			
		
		} 
		else if (is_file($file)) {
			if($this->type=='form'){
				if($this->parentCheck()){
					$this->path=$this->ap.DS.'Pages'.DS.$this->parent.DS.'sections'.DS;
				}
				else{
					$this->path=$this->ap.DS.'sections'.DS;
				}
			}
			if($this->type!="project"){
				$files['files'][] = str_replace(array('struct'.DS.$this->type.DS,'name'), array($this->path,$this->name), $file);
			}else{
				$files['files'][] = str_replace('struct'.DS.$this->type.DS, $this->path, $file);
			}

			$files['old'][] = $file;
		
		}
		}
		closedir($handle);
		}
	}

	return $files;
	}
	public function getFileList(){
		$files=$this->read_all_files('struct'.DS.$this->type);	
		return $files;

	}
	public function replace($str){
		$p="All";
		if(($this->type=='logic' || $this->type=='sections' || $this->type=='form') && $this->parent==null){
			$this->parent='';
		}
		else{
			$p=ucfirst($this->parent);
			$this->parent='Pages_'.ucfirst($this->parent).'_';
		}

		$str=str_replace(array('[:name]','[:Name]','[:Pages_Parent_]','[:Parent]'), 
			array($this->name,ucfirst($this->name),$this->parent,$p), 
			$str);

		return $str;
	}
	private function makeFile($file, $str){
		$f=fopen($file, 'w+');
		fwrite($f,$str);
		fclose($f);
	}
	public function createTemplate(){

		//function ni assign karel value kyarey direct call na thay
		$this->files=$this->getFileList();
		
		foreach ($this->files['dirs'] as $dir) {
			if(!is_dir($dir)){

				mkdir($dir,0777,true);
			}
		}
		$i=0;

		foreach ($this->files['files'] as $file) {
			
			$str=file_get_contents($this->files['old'][$i]);
			if($this->type != 'project'){
				$str=$this->replace($str);
			}
			$this->makeFile($file,$str);
			$i++;
		}
	}


}
?>