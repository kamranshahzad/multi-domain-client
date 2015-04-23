<?php


class config{
	
	const ENV               = 'development'; // development, production
	const EMAIL_DEBUG       = false;
	const LOCAL_DOMAIN		= 'CLINET_APP';
	const LIVE_DOMAIN		= 'URL';
	const SITE_NAME			= 'Title';
	const SECURITY_KEY 		= 'KEY_STRING';
	
	private $dbConfig		= array(
								'development'=>array('domain'=>'localhost' ,'dsn'=>array('host'=>'localhost','dbname'=>'server_app','username'=>'user','password'=>'pass')) ,
								'production'=>array('domain'=>'localhost' ,'dsn'=>array('host'=>'localhost','dbname'=>'server_app','username'=>'user','password'=>'password'))
							);
							
	public $debugConfig		= array(
								'debugemails'=>array('admin_email_id'),
							);
							
	public $mediaConfig		= array(
								'allowimgtypes' =>  array( 'image/png', 'image/jpeg', 'image/jpeg', 'image/jpeg', 'image/gif'),
								'gridimage'=> array('size'=>array( 'width'=>120,'height'=>90 )), 
								'companylogo'=>array('size'=>array( 'width'=>274,'height'=>45 ) , 'dir'=>'/'),
								'banner'=>array('size'=>array( 'width'=>957,'height'=>300 )),
								'adminimgs' => 'public/images/'
							);
							
	
	private $vendersConfig =  array('jquery'=>array('js'=>array('jquery/jquery.min')),
									'fancybox'=>array('js'=>array('fancybox/jquery.fancybox') , 'css'=>array('fancybox/jquery.fancybox')),
									'colorbox'=>array('js'=>array('colorbox/jquery.colorbox-min') , 'css'=>array('colorbox/colorbox'))
									);
	
	private $siteImages    = '/public/images/';
						

	function __construct(){
	}
	
	public function getDbConfig(){
		return 	(self::ENV == 'development') ? $this->dbConfig['development'] : $this->dbConfig['production'];
	}
	
	public function getBasePath(){
		return 	(self::ENV == 'development') ? 'http://localhost/'.self::LOCAL_DOMAIN : 'http://www.'.self::LIVE_DOMAIN;	
	}
	
	public function getVender($vender){
		if(array_key_exists($vender, $this->vendersConfig)){
			return $this->vendersConfig[$vender];
		}
	}
	
	public function getSiteImages(){
		return $this->siteImages;	
	}
	
	
	public function getImages(){
		return $this->admImages;	
	}
	
	
	public function getSiteID(){
		$keyVariable = self::SECURITY_KEY;
		if(!empty($keyVariable)){				
			$rawArray = explode('@', $keyVariable );
			if(!empty($rawArray)){
				return $rawArray[0];
			}
		}
	}
	
	
	
}//$






?>