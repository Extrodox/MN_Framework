<?php
class MN_Section_Collection extends MN_Section_Class{
	
	public $separator;
	public $members=array();

	public function setSeparator($separator){
		$this->separator=$separator;
	}
	public function prependMember($member){
		
		if($member instanceof MN_Section_Class){
			$this->members=array_merge(array($member->toHTML()),$this->members);
			//$this->members[]=$member->toHTML();
		}else{
			$this->members=array_merge(array($member),$this->members);
			//$this->members[]=$member;
		}
	

	}
	public function appendMember($member){

		if($member instanceof MN_Section_Class){
			$this->members[]=$member->toHTML();
		}else{
			$this->members[]=$member;
		}

	}
	public function addMember($member,$memberName=null){
		if(!is_Null($memberName)){
			if($member instanceof MN_Section_Class){
				$this->members[]=$member->toHTML();
			}else{
				$this->members[]=$member;
			}
		}else{
			if($member instanceof MN_Section_Class){
				$this->members[$memberName]=$member->toHTML();
			}else{
				$this->members[$memberName]=$member;
			}
		}

	}

	public function setInnterHTML($html=null){
		$this->body=implode($this->separator, $this->members);
	}
	public function deleteMember($memberName){
		unset($this->members[$memberName]);
	}
	public function toHTML(){
		$this->setInnterHTML();
		return parent::toHTML();
	}

}