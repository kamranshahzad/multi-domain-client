<?php
	require_once("devkit/init.php");	
	require_once('blocks.php');
	$boot = new bootstrap();
	$asset =  $boot->siteimg;
	$baseURL 		=  $boot->basepath;
	
	$portObject = new Portfolio();
	$moduleObject = new ModulePages();
	$dataArray = $moduleObject->fetchModulePages('gallery');
	
	$setObject 		= new Settings();
	$defaultgoogleCodes 	= $setObject->fetchById('googlecodes');
	$defaultjsCodes 		= $setObject->fetchById('jscodes');
	$defaultNoFollow		= $setObject->fetchById('nofollowdays');
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="public/images/favicon.jpg" />
<title><?php echo ArrayUtil::value('head_title',$dataArray); ?></title>
<meta name="keywords" content="<?php echo ArrayUtil::value('head_keywords',$dataArray); ?> " />
<meta name="description" content="<?php echo ArrayUtil::value('head_description',$dataArray); ?>" />
<meta name="Classification" content="<?php echo StringUtil::short(ArrayUtil::value('head_keywords',$dataArray) , 60); ?>" />
<meta name="ROBOTS" content="index, follow" />
<meta name="rating" content="General" />
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta name="revisit" content="<?php echo $defaultNoFollow; ?> days" />
<?php echo $boot->drawCss('public/css',array('styles')); ?>
<?php echo $boot->drawJs('public/js',array('jsmini','jquery-ui.min','jquery.easing.1.3','slides.jquery','init-js','news-ticker' , 'mux-lightbox'));?>
<?php echo $boot->drawVender('venders','colorbox');?>
<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'public/siteimages/loading.gif',
				play: 5000,
				pause: 3000,
				hoverPause: false
			});
			
			$(".portfolioImageItem").lightbox();
			//$(".ajax").colorbox({innerWidth:800, innerHeight:580});
		});
</script>
<style type="text/css">
	.portfolioImageItem { cursor:pointer;}
</style>    
</head>
<body>

<div class="logoWrapper">
	<!-- #logoWrapper-->
    	<div class="logoImage center">
        	<a href="<?php echo $baseURL.'/index.php'; ?>">
    		<img src="<?php echo $asset; ?>logo.jpg" width="713" height="73" style="border:none;" alt="WS Nielsen logo" />
            </a>
    	</div>
    <!-- $logoWrapper-->
</div>


<div class="contentWrapper">
	<!-- #contentWrapper-->
	
    <div class="bannerContainer center">
    <!-- $bannerContainer-->
        <?php echo drawSlideBanner($boot);?>
    <!-- #bannerContainer-->
    </div>
    <div class="clear"></div>	
    
    
    <div class="mainContainer center">
    <!-- #mainContainer-->


        <div class="leftContainer left">
        <!-- $leftContainer-->
              
              <?php echo drawMenus('left');?>
              
              <div class="testimonialContainer">
              	<!-- #testimonialContainer-->
                 <h2>Testimonials</h2>
                 
                 <?php echo drawTestimonialWidget(); ?>
                 
                <!-- $testimonialContainer-->
              </div>
              
              
              <div class="newsletterContainer">
              <!-- #newsletterContainer-->
              	<?php echo drawNewsletterWidget(); ?>
              <!-- $newsletterContainer-->
              </div>
              
              <div class="socialmedia">
              	<?php echo drawBlock('socialicons');?>
              </div>
              
              
              
        <!-- #leftContainer-->
        </div>
        
        <div class="rightContainer right">
        <!-- $rightContainer-->
           
           <div class="contentContainer">
           <h1><?php echo ArrayUtil::value('page_title',$dataArray); ?></h1>
           		

                <?php
					$pageText = ArrayUtil::value('page_text',$dataArray); 
                	if(!empty($pageText)){
						echo '<p>'.$pageText.'</p><br/>';	
					}
				?>
                
               <div class="portfolioWrapper">

                    <?php 
                       echo $portObject->drawPortfolio();
                    ?>
                    <div class="clear"></div> 
                    
               </div><!-- $portfolioWrapper -->

           </div>
                
        <!-- #rightContainer-->
        </div>
        <div class="clear"></div>
    
    <!-- $mainContainer-->
    </div>
    
    <!-- $contentWrapper-->
</div>



<div class="footerWrapper">
<!-- #footerWrapper--> 
     <div class="footerContainer center">
     	
        <div class="footerMenu">
            <?php echo drawMenus('footer');?>
        </div>
        <div class="clear"></div>
        
        <div class="leftSide left">
            <div class="copyright">
            	<?php echo drawBlock('copyright');?>
			</div>
        </div>
      	<div class="rightSide right">
        	
        </div>
        <div class="clear"></div>      
      
     </div>
<!-- $footerWrapper--> 
</div>

</body>
<?php 
	echo $defaultgoogleCodes;
	echo '<br/>';
	echo $defaultjsCodes;
?>
</html>
<?php echo Message::getResponseJsMessage();?>