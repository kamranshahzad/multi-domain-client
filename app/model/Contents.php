<?php

	class Contents extends Model {
		
		const _TABLE = 'ml_contents';
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
			_helper functions
		*/
		public function fetchById($id){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "content_id='$id'");
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0];
			}
		}
		
		public function getMenuText($option=''){
			$textString = '';
			if(!empty($option)){
				$menuObject = new Menus();
				$data = $menuObject->fetchById($option);
				$textString = $data['menu_label'];
			}else{
				$textString = '---';
			}
			return $textString;
		}
		
		
		
		public function findContentByUrl($contentUrl){
			
			$notfound = false;
			$dataArray = array();
			$this->initDb();
			
			
			$sqlQuery = "SELECT * FROM ml_menus INNER JOIN ml_contents ON ml_menus.menu_id = ml_contents.menu_id WHERE ml_menus.menu_url='$contentUrl' AND domain_id='{$this->_DM_ID}' GROUP BY ml_menus.menu_id";
			$resultArray1 = $this->_db->run($sqlQuery);
			if(count($resultArray1) > 0){
				$dataArray = $resultArray1[0];
				$dataArray['pagetype'] = 'page';
				$notfound  = true;
			}
			
			if(!$notfound){
				$resultArray2 = $this->_db->select("ml_block_pages" , " page_url = '$contentUrl' AND domain_id='{$this->_DM_ID}'");
				if(count($resultArray2) > 0){
					$dataArray = $resultArray2[0];
					$dataArray['pagetype'] = 'block';
				}	
			}
			$this->dispose();			
			
			return $dataArray;
		}
		
		
		
		public function findContentUrl( $menu_id , $menu_type){
			$this->initDb();
			$condition = '';
			if($menu_type == 'LEFT'){
				$condition = "left_menu_id = '$menu_id'";
			}else{
				$condition = "bottom_menu_id ='$menu_id'";
			}
			$dataArray = $this->_db->select(self::_TABLE, $condition );
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0]['content_url'];
			}
		}
		
		
		public function drawLeftMenus($input = 999){
			$htmlString = '<span style="color:#ff740e;font-size:11px;">No Menu Item</span>';
			$this->initDb();
			$dataArray = $this->_db->select(Menus::_TABLE , 'menu_type="LEFT" AND status = "Y"');
			//print_r($dataArray);
			$this->dispose();
			if(count($dataArray) > 0){
				$htmlString = '<select name="left_menu_id" id="left_menu_id"><option value="">Select Menu Item</option>';
				foreach($dataArray as $array){
					if($input == $array['menu_id'] ){
						$htmlString .= '<option value="'.$array['menu_id'].'" selected="selected">'.$array['menu_label'].'</option>';	
					}else{
						$htmlString .= '<option value="'.$array['menu_id'].'">'.$array['menu_label'].'</option>';
					}
				}
				$htmlString .= '</select>';	
			}
			return $htmlString;
		}
		
		
		public function drawFooterMenus($input = 999){
			$htmlString = '<span style="color:#ff740e;font-size:11px;">No Menu Item</span>';
			$this->initDb();
			$dataArray = $this->_db->select(Menus::_TABLE , 'menu_type="BOTTOM" AND status = "Y"');
			$this->dispose();
			if(count($dataArray) > 0){
				$htmlString = '<select name="bottom_menu_id" id="bottom_menu_id"><option value="">Select Menu Item</option>';
				foreach($dataArray as $array){
					if($input == $array['menu_id'] ){
						$htmlString .= '<option value="'.$array['menu_id'].'" selected="selected">'.$array['menu_label'].'</option>';	
					}else{
						$htmlString .= '<option value="'.$array['menu_id'].'">'.$array['menu_label'].'</option>';
					}
				}
				$htmlString .= '</select>';	
			}
			return $htmlString;
		}
		
		
		
		/* content svn */
		
		
		public function isExistsInMenuItem($pagename , $menuid = 0 ){
			$this->initDb();
			$dataArray = $this->_db->select("menus" , "menu_label='$pagename'");
			$this->dispose();
			if(count($dataArray) > 0){
				if($dataArray[0]['menu_id'] == 	$menuid ){
					return false;
				}
				return true;
			}
			return false;
		}
		
		public function isExistsInMenuUrl($pageurl , $menuid = 0 ){
			$this->initDb();
			$dataArray = $this->_db->select("menus" , "menu_url = '$pageurl' ");
			$this->dispose();
			if(count($dataArray) > 0){
				if($dataArray[0]['menu_id'] == 	$menuid ){
					return false;
				}
				return true;
			}
			return false;
		}
		
		// fort step 2 for block pages
		public function BlockisExistsInMenuUrl($pageurl ){
			$this->initDb();
			$dataArray = $this->_db->select("menus" , "menu_url = '$pageurl' ");
			$this->dispose();
			if(count($dataArray) > 0){
				return true;
			}
			return false;
		}
		
		
		
		public function loadContentsById($contentid){
			$this->initDb();
			$sqlQuery = "SELECT * FROM menus INNER JOIN contents ON menus.menu_id=contents.menu_id WHERE contents.content_id='$contentid' GROUP BY menus.menu_id";
			$dataArray = $this->_db->run($sqlQuery);
			$this->dispose();
			return $dataArray[0];
		}
		
		
		
		public function SaveContentPlacement($pagename, $menuarray , $menuid = 0 , $cid = 0){
			$menuString = '';
			$this->initDb();
			if(count($menuarray) > 0){
				$menuString = implode(',',$menuarray);	
			}
			
			if($cid == 0){
				$data = array('menu_label'=>$pagename , 'menu_types'=>$menuString);
				$menuid = $this->save( 'menus' , $data , '' , $this->_db);
				$data2 = array('menu_id'=>$menuid,'date_created' => DateUtil::curDateDb());
				$contentid = $this->save( 'contents' , $data2 , '' , $this->_db );
			}else{
				$data = array('menu_label'=>$pagename , 'menu_types'=>$menuString);
				$menuid = $this->save( 'menus' , $data , "menu_id='$menuid'" , $this->_db);	
			}
			
			$this->dispose();	
		}
		
		
		public function SaveContentText($pageheading, $pagetext , $menuid = 0 , $cid = 0){
			$this->initDb();
			
			$data = array('page_title'=>$pageheading,'page_text ' => $pagetext);
			$this->save( 'contents' , $data , "content_id='$cid'" , $this->_db );
			
			$this->dispose();	
		}
		
		
		/*
			_sitemap
		*/
		public function scanUrls(){
			
			$blockUrls = $contentUrls = array();
			$this->initDb();
			$blockPages = $this->_db->select("block_pages");
			if(count($blockPages) > 0){
				foreach($blockPages as $array){
					$blockUrls[] = $array['page_url'];
				}
			}
			
			$conetntPages = $this->_db->select("menus");
			if(count($conetntPages) > 0){
				foreach($conetntPages as $array){
					$contentUrls[] = $array['menu_url'];
				}
			}
			
			$outputUrls = array_merge($contentUrls,$blockUrls);
			return $outputUrls;
		}
		
		
		public function buildSiteMap(){
			
			$boot = new bootstrap();
			$pagesArray = $this->scanUrls();
			$urlArray  	= array();
			$urlArray[] =  $boot->basepath;
			foreach($pagesArray as $array){
				$urlArray[] = $boot->basepath.'/'.$array;	
			}
			
			if(count($urlArray) > 0){
				$_sitemap = new Sitemap('../Sitemap.xml');
				$_sitemap->load();
				foreach($urlArray as $url) {
					$array = array('loc'=>$url,'lastmod'=>'2012-12-03');
					$_sitemap->addrow($array);
				}
				$_sitemap->dom->save('../Sitemap.xml'); 
			}
		}
		
		
		
		
	}  // $
