<?php

	class Banner extends Model {
		
		const _TABLE = 'ml_banners';
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
				return $this;
			}catch(PDOException $e) {  
				echo $e->getMessage();  
			}
		}
		
		public function dispose(){
			$this->_db = null;
		}

		/*
			helper functions
		*/
		public function fetchById($id){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "banner_id='$id'");
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0];
			}
		}
		
		public function fetchByAllEnabled(){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE , "status='Y' AND domain_id='{$this->_DM_ID}'");
			$this->dispose();
			if(count($dataArray) > 0){
				$tmpArray = array();
				foreach($dataArray as $array){
					if(!empty($array['banner_image'])){
						$tmpArray[$array['banner_image']] = $array['image_alttag'];
					}
				}
				return $tmpArray;
			}
		}
		
	}  // $
