<?php


	class SiteMap{
		
		
		private $_db = NULL;
		
		public function __construct() {}	
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
		
		
		// workers
		
		
		
		
		
		
	} //@