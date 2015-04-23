<?php

	class Newsletter extends Model {
		
		const _TABLE = 'newsletter';
		private $_db = NULL;
			
		public function __construct() {}	
		
		public function initDb(){
			$configObj 	= new config();
			$_dbinfo 	= $configObj->getDbConfig();
			try {
				$this->_db = new Pdodb($_dbinfo);
			}catch(PDOException $e) {  
				echo $e->getMessage();  
			}
		}
		public function dispose(){
			$this->_db = null;
		}
		
		
		/*
			_processing functions
		*/
		public function checkEmail($email){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "email LIKE '%$email%'");
			$this->dispose();
			print_r($dataArray);
			if(count($dataArray) > 0){
				return true;
			}
			return false;
		}
		public function checkIp($ip){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "ip_address = '$ip'");
			$this->dispose();
			if(count($dataArray) > 0){
				return true;
			}
			return false;
		}
		public function fetchByIdentifier($identifier=''){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "identifier='$identifier' AND status='Y'");
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0]['block_text'];
			}
		}
		
		public function unsubscribe($email){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, " email='$email' ");
			if(count($dataArray) > 0){
				if($dataArray[0]['subscribed'] == 'Yes'){
					// ready to unscribed.
					$data = array('subscribed'=>'No');
					$this->save( self::_TABLE , $data , "email='$email'" , $this->_db);
					return 'done';
				}else{
					return 'aleady';
				}
			}
			$this->dispose();
			return 'not';
		}
		
		
		
		public function drawNewsletterWidget(){
			
			$htmlString = '';
			
			$htmlString .= '<table cellpadding="3" cellspacing="0" border="0" class="tinywidgetTable">';
			$htmlString .= '<tr>';
			$htmlString .= '<td class="head">Subscriber Name</td>';
			$htmlString .= '<td class="head">Subscriber Email</td>';
			$htmlString .= '<td class="head">Created Date</td>';
			$htmlString .= '<td class="head rightrow">IP Address</td>';
			$htmlString .= '</tr>';
			$htmlString .= '<tr>';
			$htmlString .= '<td class="row">test</td>';
			$htmlString .= '<td class="row">test@hotmail.com</td>';
			$htmlString .= '<td class="row">2012/10/17</td>';
			$htmlString .= '<td class="row rightrow">229.332.214.102</td>';
			$htmlString .= '</tr>';
			$htmlString .= '</table>';
			
			return $htmlString;	
		}
		
		
		public function removeSubscribers($ids){
			if(count($ids)> 0){
				
				$this->initDb();
				foreach($ids as $id){
					$this->remove(self::_TABLE , "letter_id='$id'" , $this->_db);
				}
				$this->dispose();
				return true;
			}
			return false;
		}
		
		
		
		
		
		
		

		
	}  // $
