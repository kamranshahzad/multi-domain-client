<?php

	
class NewsletterController extends Controller {
	
	private $_dbinfo;
	private $_db;
		
	function __construct() {
		$configObj 	= new config();
		$this->_dbinfo 	= $configObj->getDbConfig();
		parent::__construct();			
		call_user_func(array($this, $this->getAction()));
	}
	
	private function findAction(){
		
		$email = $this->getValue('emailtext');
		Request::redirect("newsletter-emails.php?q=show&email=".$email);	
	}
	
	
	private function subscribeAction(){
		
		if (strlen(session_id()) < 1) {
				session_start();
		}
		
		$this->_db = new Pdodb($this->_dbinfo);
		
		$name = $this->getValue('nameField');
		$email = $this->getValue('emailField');
		$IP_ADDRESS = Request::ip();
				
		$letterObject = new Newsletter();
		
		$valid_time = true;
		if(isset($_SESSION['timestmc'])){
			$mailtime = DateUtil::eventTime($_SESSION['timestmc'], 20);
			if($mailtime == 'false') $valid_time = false;
		}
		
		
		if($valid_time == true){
			if($letterObject->checkEmail($email)){
				// Already exist in our db
				Message::setResponseJsMessage("You have already subscribed.",'s');
				header("Location: {$_SERVER['HTTP_REFERER']}");
			}else{
				$data = array('name'=>$name,'email'=>$email,'ip_address'=>$IP_ADDRESS,'date_created'=>DateUtil::curDateDb());	
				$letterObject->save( Newsletter::_TABLE , $data , '' ,$this->_db);
				$_SESSION['timestmc'] = date('H:i:s');
				Message::setResponseJsMessage("Thank you for subscribing our newsletter.",'s');
				header("Location: {$_SERVER['HTTP_REFERER']}");
			}
		}else{
			Message::setResponseJsMessage("You have already subscribed.",'s');
			header("Location: {$_SERVER['HTTP_REFERER']}");	
		}
	}
	
	
	
} //$