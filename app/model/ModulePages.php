<?php


	class ModulePages extends Model {
		
		const _TABLE = 'ml_module_pages';
		private $_db = NULL;
		public $_DM_ID = 0;	
		
		public function __construct() {
			$configObj 	  = new config();
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
		
		// core functions
		public function fetchModulePages($module =''){
			$this->initDb();
			$pagesArray = $this->_db->select( self::_TABLE , "domain_id='{$this->_DM_ID}'");
			$dataArray = array();
			
			if(count($pagesArray) > 0){
				$dataArray['news'] 		= $pagesArray[3];
				$dataArray['test'] 		= $pagesArray[2];
				$dataArray['gallery'] 	= $pagesArray[1];
				$dataArray['home'] 		= $pagesArray[0];	
			}
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[$module];
			}
		}
		
		public function fetchModulePagesById($id){
			$this->initDb();
			$dataArray = $this->_db->select( self::_TABLE , "page_id='$id'");
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0];
			}
		}
		
		public function drawModulePages($pagesarray=array()){
			if(!empty($pagesarray)){
				$sqlQuery = '';
				if(count($pagesarray) > 0){
						
				}
			}
		}
		
		public function drawInClause($array=array()){
			$string = '';
			$string = 'IN ('.join(',',$array).')';
			return $string;
		}
		
		

	} //$