<?php
	require_once("devkit/init.php");	
	require_once('blocks.php');
	$boot = new bootstrap();
	$asset =  $boot->siteimg;
	
	$moduleObject 	= new ModulePages();
	$dataArray 		= $moduleObject->fetchModulePages('home');
	
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
<?php echo $boot->drawJs('public/js',array('jsmini','jquery.easing.1.3','slides.jquery','init-js','news-ticker'));?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'public/images/loading.gif',
				play: 5000,
				pause: 3000,
				hoverPause: false
			});
		});
		
</script>    
</head>
<body>

<div class="logoWrapper">
	<!-- #logoWrapper-->
    	<div class="logoImage center">
    		<img src="<?php echo $asset; ?>logo.jpg" width="713" height="73" alt="WS Nielsen logo" />
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

		
        <div class="bgWrapper">
        
        <div class="leftContainer left">
        <!-- $leftContainer-->
              <?php echo drawMenus('left');?>    
        <!-- #leftContainer-->
        </div>
        
        <div class="rightContainer right">
        <!-- $rightContainer-->
           
           	<div class="missionContainer">
            <!-- #missionContainer-->
            	<?php echo ArrayUtil::value('page_text',$dataArray); ?>
            <!-- $missionContainer-->
            </div>
               
        <!-- #rightContainer-->
        </div>
        <div class="clear"></div>
    	
        </div><!-- $bgWrapper -->
        
        
        <div class="boxContainer">
            <!-- #boxContainer-->
            	
                <div class="boxItem left">
                	<?php echo drawBlock('box1');?>
                </div>
                
                <div class="boxItem left">
					<?php echo drawBlock('box2');?>
                </div>
                
                <div class="boxItem left">
                	<?php echo drawBlock('box3');?>
                </div>
                
                <div class="boxItem left">
                	<?php echo drawBlock('box4');?>
                </div>
                
                <div class="clear"></div>
                
            <!-- $boxContainer-->
        </div>
        
        
        
        <div class="bottomleftContainer left" >
        	   
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
              
              
        </div><!-- $leftContainer-->
        
        <div class="rightContainer right">
        
            	<div class="newsContainer">
                <!-- #newsContainer-->
                    <h2>Latest News</h2>
                    <?php echo drawNewsWidget(); ?>
                    
                <!-- $newsContainer-->    
                </div>
        
        </div><!-- $rightContainer-->
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
            	<?php echo drawCopyrights();?>
			</div>
        </div>
      	<div class="rightSide right">
        	&nbsp;
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