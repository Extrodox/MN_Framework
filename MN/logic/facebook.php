<?php
set_time_limit(0);

class Logic_Facebook extends MN_Logic_Abstract{


	public $scope= array ( 
		'scope'  =>  FB_SCOPE ,
		'redirect_uri' =>"",
		'fileUpload' => true
		);
	

	public $fb;

	public $user;
	
	public $profile;

	public $fields="?fields=first_name,last_name,gender,email";

	public function __construct(){
		parent::__construct();
		$this->scope['redirect_uri']=$this->getRedirectLink();
	}
	private function getRedirectLink(){
		$append="";$prepend="http";
		if(isset($_GET['fbapp'])){
			$append="&fbapp";
		}
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=="on"){
			$prepend.="s";
		}
		return ($prepend."://".$_SERVER['HTTP_HOST'].FB_REDIRECT_URL."?mainpage=".PAGE_MAIN.$append);
	}
	public function run(){
		if(!isset($_SESSION['fbid'])){
			$this->login();
		}
	}

	public function login(){
		$this->getFBObj();
		return $this->getUser();

	}

	public function getFBObj(){
		if($this->fb==null){
			$this->fb = new FB_Class(array(
			  'appId'  => FB_APPID,
			  'secret' => FB_SECRET
			));
			FB_Class::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
			FB_Class::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;
			$this->fb->getSignedRequest();
		}
		
		return $this->fb;
	}

	public function getUser(){
		$this->fb=$this->getFBObj();
		$this->fb->setFileUploadSupport(true);
		// Get User ID
		return $this->user = $this->fb->getUser();

	}

	public function getLoginURL(){
		return $this->fb->getLoginUrl($this->scope);
	}

	public function getLogoutURL(){
		return $this->fb->getLogoutUrl();
	}

	public function getUserProfileData(){
		return $this->fb->api('/'.$this->view->user.$this->fields);
	}
	
	public function postPhoto($path,$message){
		if(!isset($_SESSION['fbid'])){
			die();
		}
		$this->login();
		return $this->fb->api('/me/photos', 'POST', array(
                                     'source' => '@' .realpath($path),
                                     'message' => $message,
                                     )
                                  );	
	}

	public function addScore($score){
		if(isset($_SESSION['fbid'])){
			try{
				$this->login();
				$response = $this->fb->api(
				    "/me/scores",
				    "POST",
				    array (
				        'score' => $score,
				    )
				);
			}catch(Exception $e){
				var_dump($e);
			}
			
		}
	}
}
