<?php

	class Portfolio extends Model {
		
		const _TABLE = 'portfolio';
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
			helper functions
		*/
		public function fetchById($id){
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "pid='$id'");
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0];
			}
		}
		
		
		
		/*
			front-end grid
		*/		
		public function drawPortfolio(){
			
			$htmlString = '';
			
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE ,"status = 'Y'");
			$totalRecords = count($dataArray);
			$boot = new bootstrap();
			$setObject = new Settings();  // get custom setting values
			$defaultportfolio = $setObject->fetchById('portfolio');
			$thumbWidth  = $setObject->getByJson('twidth',$defaultportfolio);
			$thumbHeight = $setObject->getByJson('theight',$defaultportfolio);
			$noItemsScroll      =  $setObject->getByJson('nodisplay',$defaultportfolio);
			$containerWidth 	= $thumbWidth + 10;
			$containerHeight	= $thumbHeight + 55 + 18; 
			$displaystyle 		=  $setObject->getByJson('displaystyle',$defaultportfolio);
			
			
			if($totalRecords > 0){
				$record_per_page	= $noItemsScroll;
				$scroll				= 5 ;
				$page 				= new Pagger();
				$page->set_page_data( $totalRecords,$record_per_page,$scroll,true,true,true);
				$sqlQuery = $page->get_limit_query("SELECT * FROM ".self::_TABLE." WHERE status = 'Y' ORDER BY pid DESC");				
				$resultArray = $this->_db->run($sqlQuery);
				foreach($resultArray as $array){
					
					$imageSrc = $boot->media.'/portfolio/thumbs/'.$array['image'];
					//$imgTag   = ($displaystyle == 'a') ? '<a class="ajax" href="portfolio-popup-details.php?pid='.$array['pid'].'"><img src="'.$imageSrc.'" style="border:none;" /></a>' : '<a href="portfolio-details.php?pid='.$array['pid'].'"><img src="'.$imageSrc.'" style="border:none;" /></a>';
					$imgTag   = ($displaystyle == 'a') ? '<img class="portfolioImageItem" data-portfolioid="'.$array['pid'].'" src="'.$imageSrc.'" style="border:none;" /></a>' : '<a href="portfolio-details.php?pid='.$array['pid'].'"><img src="'.$imageSrc.'" style="border:none;" /></a>';
					
					$htmlString .= '<div class="portfolioItem round left" style="width:'.$containerWidth.'px;height:'.$containerHeight.'px;overflow:hidden;">
										'.$imgTag.'
										<p>
										'.StringUtil::short($array['short_description'], 100 ).'
										</p>
									</div>';	
				}
				$htmlString .= '<div class="paggingWrapper">'.$page->get_page_nav("", true).'</div>';
			}else{
				$htmlString .= '';	
			}
			$this->dispose();
			return $htmlString;	
		}
		
		

		
	}  // $
