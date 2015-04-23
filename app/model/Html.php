<?php

	class Html extends Model {
		
		const _TABLE = 'ml_blocks';
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
			$dataArray = $this->_db->select(self::_TABLE, "block_id='$id'");
			$this->dispose();
			if(count($dataArray) > 0){
				return $dataArray[0];
			}
		}
		
		
		public function fetchByIdentifier($identifier=''){
			$htmlString = '';
			$boot = new bootstrap();
			$media = $boot->media.'/block/thumbs/';
			$bpageObject = new BlockPages();
			
			$this->initDb();

			$dataArray = $this->_db->select(self::_TABLE, "identifier='$identifier' AND status='Y' AND domain_id='{$this->_DM_ID}'");
			
			$this->dispose();
			if(count($dataArray) > 0){
				
				$array = $dataArray[0];
				$urlString = '';
				
				if($array['block_type'] == 'Y'){
					$urlString = $boot->basepath.'/'.$bpageObject->fetchByBlockIdentifier($array['identifier']);
				}

				if(!empty($array['image'])){
					if($array['islink'] == 'Y'){		
						$htmlString .= '<a href="'.$urlString.'"><img src="'.$media.$array['image'].'" style="border:none;" alt="'.$array['alt_tag'].'" /></a>';
					}else{
						$htmlString .= '<img src="'.$media.$array['image'].'" style="border:none;" alt="'.$array['alt_tag'].'" />';
					}
				}
				$htmlString .= '<h1>'.$array['block_title'].'</h1>';
				$htmlString .= $array['block_text'];
				if($array['islink'] == 'Y'){
					$htmlString .= '<span class="blockreadmore"><a href="'.$urlString.'" >read more...</a></span>';
				}
			}
			
			return $htmlString;
		}
		

		
	}  // $
