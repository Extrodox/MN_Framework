<?php
class MN_Section_Class{
	private $tabName;
	protected $body;
	private $attributes=array();
	private $enabled=true;
	private $view;
	private static $objects=array();
	private $nameRegExp="/^[a-zA-Z0-9]*$/";
	private $name;
	public function __construct($uniqueName,$tagName="section"){
		$this->name=$uniqueName;
		try{
			if(preg_match($this->nameRegExp,$uniqueName)){
				try{
					if(isset($objects[$uniqueName]) && self::$objects[$uniqueName] instanceof self){
						throw new Exception("Name $uniqueName is already taken for section object ",1);
					}
					self::$objects[$uniqueName]=$this;

					$this->tagName=$tagName;
				}catch(Exception $e){
					Debug::label($e->getMessage());
					Debug::show(self::$objects[$uniqueName]);
					die();
				}		
			}else{
				throw new Exception("Name $uniqueName is not a valid name ",1);
			}
		}catch(Exception $e){
			Debug::label($e->getMessage());
			Debug::show("only a-z , A-Z and 0-9 are allowed the regExp for validation is \"{$this->nameRegExp}\"");
			die();
		}
		
	}
	public function addAttributes($array){
		$this->attributes=array_merge($this->attributes,$array);
	}
	public function setAttibute($name,$value){
		$this->attributes[$name]=$value;
	}
	public function remoteAttribute($name){
		unset($this->attributes[$name]);
	}
	public function setInnterHTML($html){
		if($html instanceof MN_Section_Class){
			$this->body=$html->toHTML();
		}else{
			$this->body=$html;
		}
		
	}
	public function toHTML(){
		$s="SECTION_".strtoupper($this->name);
		if(!defined($s) || constant($u)==true){
			return "<{$this->tagName} {$this->attrbToHTML()}> {$this->body} </{$this->tagName}>";			
		}else{
			return "";
		}
		
	}
	private function attrbToHTML(){
		$string="";
		foreach($this->attributes as $key=>$values){
			if(!is_null($values)){
				$string.=" $key=\"$values\" ";
			}
			$string.=" $key ";
		}
		return $string;
	}
	public function setEnabled($bool=true){
		$this->enabled=$bool;
	}
	public static function getSectionByName($name,$args){		
		$u=strtoupper($name);
		if(!defined("SECTION_".$u) || constant("SECTION_".$u)==true){
		try{

			if(isset(self::$objects[$name]) && self::$objects[$name] instanceof self){
				echo self::$objects[$name]->toHTML();
			}else{
				$page=isset($args[0])?$args[0]:PAGE_MAIN;

				if(is_string($page)){
					if(file_exists(MN_Autoloader_Class::fileName('Pages_'.ucfirst($page).'_Sections_'.ucfirst($name).'_Logic'))){
						$t='Pages_'.ucfirst($page).'_Sections_'.ucfirst($name).'_Logic';
						$section=new $t($args);
						$section->deploySection();
					}else if(file_exists(MN_Autoloader_Class::fileName('Sections_'.ucfirst($name).'_Logic'))){
						$t='Sections_'.ucfirst($name).'_Logic';
						$section=new $t($args);
						$section->deploySection();

					}else{
						throw new Exception("No section object found for \"$name\", Available sections are : ",1);
					}
				}else if($page===false){
					
					if(file_exists(MN_Autoloader_Class::fileName('Sections_'.ucfirst($name).'_Logic'))){
						$t='Sections_'.ucfirst($name).'_Logic';
						$section=new $t($args);
						$section->deploySection();
					}else if(file_exists(MN_Autoloader_Class::fileName('Pages_'.ucfirst($page).'_Sections_'.ucfirst($name).'_Logic'))){
						$t='Pages_'.ucfirst($page).'_Sections_'.ucfirst($name).'_Logic';
						$section=new $t($args);
						$section->deploySection();
					}else{
						throw new Exception("No section object found for \"$name\", Available sections are : ",1);
					}
				}

			}
		}catch(Exception $e){
			Debug::label($e->getMessage());
			Debug::show(array_keys(self::$objects));
			die();
		}
	}

	}
	public static function getAllNames(){
		return array_keys(self::$objects);
	}

}