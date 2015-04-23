<?php

	class Testimonial extends Model {
		
		const _TABLE = 'ml_testimonials';
		private $_db = NULL;
		public $_DM_ID = 0;	
			
		public function __construct() {
			$configObj 	= new config();
			$this->_DM_ID = $configObj->getSiteID();
		}	
		
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
		
		
	
		public function fetchById($id){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "tid='$id'");
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0];
			}
		}
		
		public function drawRandomTestimonials(){
			$htmlString = '';
			$setObject  = new Settings();
			$testString = $setObject->fetchById('test');
			$testArray  = explode(',',$testString);
			$displayOrder = $testArray[0];
			$effect       = $testArray[1];
			$OrderText = '';
			switch($displayOrder){
				case 'd':
					$OrderText = 'ORDER BY sort_order DESC';
					break;
				case 'a':
					$OrderText = 'ORDER sort_order tid';
					break;
				case 'r':
					$OrderText = 'ORDER BY RAND()';
					break;	
			}
			
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "status='Y' $OrderText");
			$this->dispose();
			 
			$textArray = array();
			if(count($dataArray) > 0){
				$htmlString .= '<ul id="testimonialsList" >';
				foreach($dataArray as $array){
					if(!empty($array['data_text'])){
						$htmlString .= '<li><p> &nbsp;&nbsp;'.StringUtil::shortGoto($array['data_text'],160,'<span class="readmore"><a href="testimonials.php">...read more</a></span>').'</p></li>';
					}
				}
				$htmlString	.= '</ul>';
				$htmlString .= '<script type="application/javascript">';
				if($effect == 'sl'){
					$htmlString .= '$("#testimonialsList").slideTestimonials({\'delay\':5000, \'fadeSpeed\': 1000});';
				}else{
					$htmlString .= '$("#testimonialsList").rotateTestimonials({\'delay\':5000, \'fadeSpeed\': 1000});';	
				}
				$htmlString .= '</script>';
			}
			return $htmlString;
		}
		
		
		public function drawAllTestimonials(){
			$htmlString = '';
			$setObject  = new Settings();
			$testString = $setObject->fetchById('test');
			$testArray  = explode(',',$testString);
	
			$displayOrder = $testArray[0];
			$OrderText = '';
			switch($displayOrder){
				case 'd':
					$OrderText = 'ORDER BY sort_order DESC';
					break;
				case 'a':
					$OrderText = 'ORDER sort_order tid';
					break;
				case 'r':
					$OrderText = 'ORDER BY RAND()';
					break;	
			}
			
			
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "status='Y' AND domain_id='{$this->_DM_ID}'  $OrderText");
			
			
			$this->dispose();
			if(count($dataArray) > 0){
				foreach($dataArray as $array){
					$htmlString .= '<blockquote><p>&nbsp;&nbsp;'.$array['data_text'].'</p></blockquote>';
				}	
			}
			return $htmlString;
		}
		
		public function setSortOrder($tid,$sortOrder,$targetTid,$targetSortOrder){
			$this->initDb();
			$data1 = array('sort_order'=>$targetSortOrder);
			parent::save( self::_TABLE , $data1 , "tid='$tid'" ,$this->_db);
			$data2 = array('sort_order'=>$sortOrder);
			parent::save( self::_TABLE , $data2 , "tid='$targetTid'" ,$this->_db);
			$this->dispose();	
		}
		
		
		
		
	}  // $
