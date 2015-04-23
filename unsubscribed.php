<?php
	require_once("devkit/init.php");
	require_once('blocks.php');
	
	$boot = new bootstrap();
	$asset =  $boot->siteimg;
	$baseURL 		=  $boot->basepath;
	
	$emailtext = $responseMessage = '';
	if(isset($_GET['email'])){
		
		$emailtext = $_GET['email'];
		if(filter_var($emailtext , FILTER_VALIDATE_EMAIL)) {
			
			$valid_time = true;
			if(isset($_SESSION['timestmc'])){
				$mailtime = DateUtil::eventTime($_SESSION['timestmc'], 20);
				if($mailtime == 'false') $valid_time = false;
			}
				
			if($valid_time == true){
				
				$mdlObject = new Newsletter();
				$response  = $mdlObject->unsubscribe($emailtext);
				switch($response){
					case 'done':
						$responseMessage = 'Your email address unsubscribed successfully.';
						//$_SESSION['timestmc'] = date('H:i:s');
						break;
					case 'aleady':
						$responseMessage = 'Your email address already unsubscribed.';break;
					case 'not':
						$responseMessage = 'You are not subscribed on WSN.';break;			
				}
			}else{
				header("Location: index.php");
			}	 
		}else{
			// Invalid Email address	
		}
	}else{
		// No email address transmited	
	}
	
	$setObject 		= new Settings();
	$defaultgoogleCodes 	= $setObject->fetchById('googlecodes');
	$defaultjsCodes 		= $setObject->fetchById('jscodes');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="public/siteimages/favicon.ico">
<title>Unsubscribe WSN Newsletter</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<?php echo $boot->drawCss('public/sitecss',array('styles')); ?>
<?php echo $boot->drawJs('public/sitejs',array('jsmini','jquery.easing.1.3','slides.jquery','init-js','news-ticker'));?>
<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'public/siteimages/loading.gif',
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
           <h1> Unsubscribe Newsletter</h1>
           
		   <p style=" font-weight:bold; line-height:30px; padding-left:10px;">
           <?php echo $responseMessage; ?>
           </p>
           
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

