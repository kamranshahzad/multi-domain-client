<?php

	class News extends Model {
		
		const _TABLE = 'ml_news';
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
			$dataArray = $this->_db->select(self::_TABLE, "news_id='$id'");
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0];
			}
		}
		
		public function drawLatestNews($showNoNews = 3){
			
			$htmlString = '';
			$boot = new bootstrap();
			$media = $boot->media.'/news/thumbs/';
			
			$setObject = new Settings();
			$defaultDate = $setObject->fetchById('dateformat');
			
			
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "status='Y' AND domain_id='{$this->_DM_ID}' ORDER BY news_id DESC LIMIT 0 , $showNoNews");
			$this->dispose();
			if(count($dataArray) > 0){
				foreach($dataArray as $array){
					
					if(!empty($array['news_img'])){
						$htmlString .= '<div class="newsItem">
								<img src="'.$media.$array['news_img'].'" width="122" height="122" class="left" />
								<div class="details right">
									<div class="newsdate">'.DateUtil::format($array['news_date'] ,$defaultDate ).'</div>
									<h2>'.$array['news_title'].'</h2>
									<p>'.$array['news_short_text'].'</p>
									<a href="news.php">more..</a>
								</div>
								<div class="clear"></div>	
							</div>';
					}else{
						$htmlString .= '<div class="newsItem">
										<div class="fulldetails">
											<div class="newsdate">'.DateUtil::format($array['news_date'] , $defaultDate).'</div>
											<h2>'.$array['news_title'].'</h2>
											<p>'.$array['news_short_text'].'</p>
											<a href="news.php">more..</a>
										</div>
									</div>';	
					}
				}
			}
			return $htmlString;
		}
		
		
		public function drawAllNews(){
			
			$htmlString = '';
			
			$setObject = new Settings();
			$defaultDate = $setObject->fetchById('main');
			
			
			$this->initDb();
			$dataArray = $this->_db->select(self::_TABLE, "status='Y' ORDER BY news_id DESC");
			$this->dispose();
			if(count($dataArray) > 0){
				foreach($dataArray as $array){
					$htmlString .= '<div class="newsWrapper">
									<!-- #newsWrapper-->
										<h2>'.$array['news_title'].'</h2>
										<div class="eventdate">'.DateUtil::format($array['news_date'] , $defaultDate ).'</div>
										<p>'.$array['news_detail_text'].'</p>
									<!-- $newsWrapper-->
									</div>';	
				}
			}
			
			return $htmlString;
		}
		
		
	}  // $
