<?php
	require_once("../../devkit/init.php");
	
	$portfoilioID = $_GET['ID'];
	$imgWidth = $imgHeight = 0;
	
	$boot = new bootstrap();
	$assetPath = $boot->media.'/portfolio/large/';

	$mdlpObject = new Portfolio();
	$dataArray  = $mdlpObject->fetchById($portfoilioID); 
	
	$setObject = new Settings();
	$defaultportfolio = $setObject->fetchById('portfolio');
	
	$imageSrc 	= $assetPath.$dataArray['image'];
	$imgWidth 	= $setObject->getByJson('lwidth',$defaultportfolio);
	$imgHeight	= $setObject->getByJson('lheight',$defaultportfolio);
	
	$contentWidth = $imgWidth + 200;
?>
<div class="windowcontent" style="width:<?=$contentWidth;?>px;">
        	
  <div class="portfoliopopup">
      <img src="<?=$imageSrc;?>" width="<?=$imgWidth;?>" height="<?=$imgHeight;?>" class="round"  />
      <p>
      <?php echo $dataArray['full_description']?>
      </p>
  </div><!-- $portfoliopopup-->
   
</div><!-- $windowcontent-->
