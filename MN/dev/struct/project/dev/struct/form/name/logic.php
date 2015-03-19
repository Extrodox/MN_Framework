<?php
class [:Pages_Parent_]Sections_[:Name]_Logic extends MN_Logic_Form{
	public function run(){
		if($this->isSubmitted()){
			if($this->isValid()){
				$this->view->report="Form is valid";
			}else{
				$this->view->errors=$this->getErrors();
			}

		}
	}
}