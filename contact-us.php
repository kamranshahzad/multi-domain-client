<?php
	require_once("devkit/init.php");	
	require_once('blocks.php');
	$boot = new bootstrap();
	$asset =  $boot->siteimg;
	$baseURL 		=  $boot->basepath;
	
	
	$form = new MuxForm('contactFrm');
	$form->setController('Contactus');
	$form->setMethod('post');
	$form->setAction('send');
	
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
<title>Contact Us</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="Classification" content="" />
<meta name="ROBOTS" content="index, follow" />
<meta name="rating" content="General" />
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta name="revisit" content="<?php echo $defaultNoFollow; ?> days" />
<?php echo $boot->drawCss('public/css',array('styles')); ?>
<?php echo $boot->drawJs('public/js',array('jsmini','jquery.easing.1.3','slides.jquery','init-js','news-ticker'));?>
<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
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
    		<img src="<?php echo $asset; ?>logo.jpg" width="713" height="73" style="border:none;" alt="WS Nielsen logo"/>
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
              
              <br />
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
           <h1>Contact Us</h1>
           
           <?php echo Message::getResponseMessage('errorMessages');?>
           
            <?=$form->init('site');?>
            <table cellpadding="0" cellspacing="6" border="0" width="100%" class="formTable">  
                <tr>
                    <td width="110" valign="middle" align="right"><label>Full Name:</label></td>
                    <td> 
                        <span id="wp-fullname">
                        <input type="text" name="fullname" id="fullname" class="textfieldCls" />
                        </span>
                    </td>
                </tr>
                <tr>
                    <td width="110" valign="middle" align="right"><label>Email:</label></td>
                    <td>
                        <span id="wp-email">
                        <input type="text" name="email" id="email" class="textfieldCls"/>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td width="110" valign="middle" align="right"><label>Phone:</label></td>
                    <td>
                        <span id="wp-phone">
                        <input type="text" name="phone" id="phone" class="textfieldCls"/>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td width="110" align="right" valign="top"><label>Comments:</label></td>
                    <td>
                    <span id="wp-comments">
                    <textarea name="comments" id="comments" cols="30" rows="5" class="ctextarea" ></textarea>
                    </span>
                    </td>
                </tr>
                <tr>
                    <td width="110" valign="middle" align="right"><label>Security Image:</label></td>
                    <td><?php echo Captcha::show('','','contact');?></td>
                </tr>
                <tr>
                    <td  colspan="2">
                    <label>Type the code shown on the image above:</label>
                    <span id="wp-scode">
                    <input type="text" name="contactscode" id="contactscode" class="textfieldCls" style="width:50px;" />
                    </span>
                    </td>
                </tr>
                <tr>
                    <td width="110" valign="middle" height="40"></td>
                    <td><input type="button" class="formButton pointer" value="Send" id="contactUsButtton"/></td>
                </tr>       
            </table>
            <?=$form->close();?>
            <br /><br /><br /><br /><br /><br /><br /><br /><br />
           	
           </div> <!-- $contentContainer-->
                
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