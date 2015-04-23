<?php

	class BlockPages extends Model {
		
		const _TABLE = 'ml_block_pages';
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
			workers
		*/
		public function loadBlockPagesById($id){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "page_id ='$id'");
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0];
			}
		}
		
		
		public function fetchByBlockIdentifier($blockidentifier='box1'){
			
			$this->initDb();
			$blockArray = $this->_db->select(self::_TABLE, "domain_id='{$this->_DM_ID}'");
			$this->dispose();
			$dataArray = array();
			
			if(count($blockArray) > 0){
				$dataArray['box1'] = $blockArray[0];
				$dataArray['box2'] = $blockArray[1];
				$dataArray['box3'] = $blockArray[2];
				$dataArray['box4'] = $blockArray[3];
			}
			
			if(count($dataArray) > 0){
				return $dataArray[$blockidentifier]['page_url'];
			}
		}
		
		
		/*
			_helper functions
		*/
		public function isExistsInMenuItem( $pagename ){
			$this->initDb();
			$dataArray = $this->_db->select( self::_TABLE , "page_title='$pagename'");
			$this->dispose();
			if(count($dataArray) > 0){
				return true;
			}
			return false;
		}
		
		public function isExistsInMenuUrl($pageurl  ){
			$this->initDb();
			$dataArray = $this->_db->select( self::_TABLE , "page_url = '$pageurl' ");
			$this->dispose();
			if(count($dataArray) > 0){
				return true;
			}
			return false;
		}
		
		
		// step2 if page is block
		public function BlockisExistsInMenuUrl($pageurl , $pageid = 0 ){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE , "page_url = '$pageurl' ");
			$this->dispose();
			if(count($dataArray) > 0){
				if($dataArray[0]['page_id'] == 	$pageid ){
					return false;
				}
				return true;
			}
			return false;
		}
		
		
		
		
	}  // $
