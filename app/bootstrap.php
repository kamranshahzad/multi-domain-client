<?php


class bootstrap extends KitBootstrap{
   
   private $configObj 	= array();
   private $debugEmail  = array();
   public $siteimg    	= '';
   public $img			= '';
   public $basepath     = '';
   public $media		= '';
   public $SITE_ID      = '';
   
   function __construct() {   
   	   date_default_timezone_set("America/Los_Angeles");
	   
	   $this->configObj 	= new config();
	   $this->siteimg 		= $this->configObj->getBasePath().$this->configObj->getSiteImages();
	   $this->img			= $this->configObj->getBasePath().$this->configObj->getImages();
	   $this->basepath  	= $this->configObj->getBasePath();
	   $this->media			= $this->configObj->getBasePath().'/media';
	   $this->debugEmail 	= $this->configObj->debugConfig['debugemails'];
	   $this->SITE_NAME     = config::SITE_NAME;
	   $this->SITE_ID		= $this->configObj->getSiteID();
   }
   
   public function getDebugEmails(){
	   return $this->debugEmail;
   }
   
   public function drawVender($location , $vender){
		return $this->fetchVenders($location , $this->configObj->getVender($vender));   
   }
   
   
   public function getMedia($medianame=''){
	    $mediaarray = $this->configObj->mediaConfig;
		if(array_key_exists($medianame,$mediaarray)){
			return $mediaarray[$medianame];	
		}
   }
   
   

    
}//$
