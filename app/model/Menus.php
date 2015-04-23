<?php

	class Menus extends Model {
		
		const _TABLE = 'ml_menus';
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
			$dataArray = $this->_db->select(self::_TABLE, "menu_id='$id'");
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0];
			}
		}
		
		
		public function drawMenus($menu_type='left'){
			$htmlString = '';
			$boot = new bootstrap();
			$baseURL = $boot->basepath;
			$this->initDb();
			$filterKey = $menu_type.'menu_sort_order';
			$sqlQuery = "SELECT * FROM ml_menus LEFT JOIN ml_contents ON ml_menus.menu_id=ml_contents.menu_id WHERE ml_menus.domain_id='{$this->_DM_ID}' AND ml_menus.menu_types LIKE '%$menu_type%' AND ml_menus.status='Y' GROUP BY ml_menus.menu_id ORDER BY ml_menus.$filterKey";
			$dataArray = $this->_db->run($sqlQuery);
			
			$this->dispose();
			if(count($dataArray) > 0){
				$htmlString .= '<ul>';
				foreach($dataArray as $array){
					$htmlString .= $this->drawExternalLinks($array['menu_label']  , $array['menu_url'] , $baseURL);	
				}
				$htmlString .= '</ul>';
			}
			return $htmlString;	
		}
		
		private function drawExternalLinks( $menu_label ,$menu_url  , $baseURL){
			$htmlString  = '';
			$htmlString .= '<li><a href="'.$baseURL.'/'.$menu_url.'">'.$menu_label.'</a></li>';	
			return $htmlString;	
		}
		
		
		public function setSortOrder($id , $sortOrder, $targetId , $targetSortOrder , $menutype ){
			$this->initDb();
			$filterKey = $menutype.'menu_sort_order';
			$data1 = array($filterKey=>$targetSortOrder);
			parent::save( self::_TABLE , $data1 , "menu_id='$id'" ,$this->_db);
			$data2 = array($filterKey=>$sortOrder);
			parent::save( self::_TABLE , $data2 , "menu_id='$targetId'" ,$this->_db);
			$this->dispose();	
		}
		
		
		public function triggerLeftMenusAutoSort(){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "menu_id IS NOT NULL ORDER BY leftmenu_sort_order");
			if(count($dataArray) > 0){
				$pointer = 1;
				foreach($dataArray as $array){
					$data = array('leftmenu_sort_order'=>$pointer );
					$menuid = $array['menu_id'];
					parent::save( self::_TABLE , $data , "menu_id='$menuid'" ,$this->_db);
					$pointer++;
				}
			}
			$this->dispose();
		}
		
		public function triggerFooterMenusAutoSort(){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "menu_id IS NOT NULL ORDER BY footermenu_sort_order");
			if(count($dataArray) > 0){
				$pointer = 1;
				foreach($dataArray as $array){
					$data = array('footermenu_sort_order'=>$pointer );
					$menuid = $array['menu_id'];
					parent::save( self::_TABLE , $data , "menu_id='$menuid'" ,$this->_db);
					$pointer++;
				}
			}
			$this->dispose();
		}
		
		
	}  // $
