<?php
	
	
	function drawSlideBanner($boot){
		$htmlString = '';
			
		$mdlObject = new Banner();
		$dataArray = $mdlObject->fetchByAllEnabled();
		$asset = $boot->media.'/banner/large/';
		
		if(count($dataArray) > 0){
			$htmlString .= '<div id="slides">
						<div class="slides_container">';					
			$selectedArray = $sourceArray[$choose];				
			foreach($dataArray as $imagename=>$alttags){
				$altTag 	= $alttags;
				$imageSrc 	= $asset.$imagename;
				$htmlString .= '<img src="'.$imageSrc.'" width="958" height="300" alt="'.$altTag.'" />';
			}
			$htmlString .= '</div>
						</div>';
			
		}else{
			$htmlString = '<p style="padding:20px;font-size:12px; color:#F00;">No banner image found.</p>';	
		}
		return $htmlString;
	}
	

	function drawMenus($menu_type='LEFT'){
		$htmlString  = '';
		$menusObject = new Menus();
		$htmlString .= '<div class="navi">';
		$htmlString .= $menusObject->drawMenus($menu_type);
		$htmlString .= '</div>';
		return $htmlString;	
	}
	
	function drawBlock($blockname=''){
		$htmlString = 'Block Content';
		$blockObject = new Html();
		$blockHtml   = $blockObject->fetchByIdentifier($blockname);
		$htmlString  = $blockHtml;
		return $htmlString;	
	}
	
	function drawNewsWidget(){
		$newsObject = new News();
		$htmlString = $newsObject->drawLatestNews();
		return $htmlString;	
	}
	
	function drawTestimonialWidget(){
		$testObject = new Testimonial();
		$htmlString = $testObject->drawRandomTestimonials();
		return $htmlString;
	}
	
	function drawCopyrights(){
		$htmlString = '';
		$setObject = new Settings();
		$bussniessnameTxt = $setObject->fetchById('bussinessname');	
		$htmlString .= 'Copyright ';
		$htmlString .= date('Y');
		$htmlString .= ' '.$bussniessnameTxt;
		return $htmlString;
	}
	
	function drawNewsletterWidget(){
		
		$htmlString = '';
		$form = new MuxForm('NewsletterForm');
		$form->setController('Newsletter');
		$form->setMethod('post');
		$form->setAction('subscribe');
		
		$htmlString .= $form->init('site');
		$htmlString .= '<h3>Subscribe to our Newsletter</h3>';
		$htmlString .= '<table cellpadding="0" cellspacing="0" border="0">';
		$htmlString .= '<tr>';
		$htmlString .= '<td><label>Name:&nbsp;</label></td>';
		$htmlString .= '<td><input type="text" name="nameField" id="nameField" class="field" /></td>';
		$htmlString .= '</tr>';
		
		$htmlString .= '<tr>';
		$htmlString .= '<td><label>Email:&nbsp;</label></td>';
		$htmlString .= '<td><input type="text" name="emailField" id="emailField" class="field" /></td>';
		$htmlString .= '</tr>';
		
		$htmlString .= '<tr>';
		$htmlString .= '<td colspan="2" valign="top"><label style="vertical-align: middle;">Type this:</label>'.Captcha::show('public/images/captcha2/','','').'</td>';
		$htmlString .= '</tr>';
		
		$htmlString .= '<tr>';
		$htmlString .= '<td colspan="2" valign="middle"><label>In this:</label>&nbsp;&nbsp;&nbsp;<input type="text" name="scode" id="scode" class="field" style="width:40px;" /></td>';
		$htmlString .= '</tr>';
		
		$htmlString .= '<tr>';
		$htmlString .= '<td></td>';
		$htmlString .= '<td><input type="button" value="Subscribe" class="button" id="newsletterButton" /></td>';
		$htmlString .= '</tr>';
		$htmlString .= '</table>';
		$htmlString .= $form->close();
		
		return $htmlString;
	}