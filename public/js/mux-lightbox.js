// JavaScript Document
(function($){
	
	var $window = $(window);
	
	$.fn.lightbox = function(){
		
		
		
		
		return this.each(function() {
			
			var $this = $(this),data = $this.data('portfolioid');
			$this.bind('click', function(e) {
				 e.preventDefault();
				 createMask();
				 loadContent(data);
			});
			
			
			$('.closewindow').live( 'click', function(){
				$(".windowcontainer").remove();
				$("#windowmask").remove();
			});

		});
				
	}
	
	function loadContent(id){
		
		createParentWindow();
		
		$.get(
			  "app/ajax/load-portfolio.php",
			  { ID: id },
			  function(data) {
				 var _html = $(data) , responseWidth = _html.width() , responseHeight = _html.height();   
				 createContentWindow(data , responseWidth , responseHeight);
			  },
			  "html"
		);
	}
	
	function createParentWindow(){
		var _html = '<div class="windowcontainer windowround windowborder windowdropshadow">\
					<img src="public/images/loader.gif" /> \
					</div><!-- $windowcontainer-->';
		var _htmlSelector =	$(_html);		
		var postion = getScrollXY() , width = _htmlSelector.width() , height = _htmlSelector.height();									
		$(document.body).prepend( _html );
		
		$(".windowcontainer").css('top', (winHeight() - height/2)  );
		$(".windowcontainer").css('left' , (winWidth()/2 - width/2)  );
	}
	
	
	function createContentWindow( _innerHtml , _responseWidth ,_responseHeight){
		
		var marginTop = 10;
		
		var _titleHtml = '<div class="titlebar">\
							<div class="titletext">\
								WSN Portfolio Images\
							</div>\
							<img src="public/images/close-icon.png" class="closewindow" />\
							<div class="clear"></div>\
						</div><!-- $titlebar-->';
		var _html = _titleHtml + _innerHtml;
		var postion = getScrollXY();
		
		/*
		$(".windowcontainer").html( _html ).animate({
            width: '+='+$(this).width(),
			height: '+='+$(this).height(),
			'top':(postion[1] + marginTop) , 'left':(winWidth()/2 - $(this).width()/2)
        }, 1500, 'easeInSine');
		*/
		
		
		$(".windowcontainer").html( _html );
		width = $(".windowcontainer").width();
		height = $(".windowcontainer").height();
		$(".windowcontainer").css({'top':(postion[1] + marginTop) , 'left':(winWidth()/2 - width/2)} );
		
		/*
		$(".windowcontainer").animate({
            width: '+='+width,
			height: '+='+height
        }, 1500, 'easeInSine');
		*/
	}
	
	function createMask(){
		var _html = '<div id="windowmask" ></div>';
		$(document.body).prepend(_html);
		var maskHeight = $(document).height();
		$('#windowmask').css({'width':winWidth,'height':maskHeight}).fadeIn(1000).fadeTo("slow",0.8);	
	}
	
	function winWidth() {
		return window.innerWidth || $window.width();
	}

	function winHeight() {
		return window.innerHeight || $window.height();
	}
	
	function getScrollXY() {
		var x = 0, y = 0;
		if( typeof( window.pageYOffset ) == 'number' ) {
			// Netscape
			x = window.pageXOffset;
			y = window.pageYOffset;
		} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
			// DOM
			x = document.body.scrollLeft;
			y = document.body.scrollTop;
		} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
			// IE6 standards compliant mode
			x = document.documentElement.scrollLeft;
			y = document.documentElement.scrollTop;
		}
		return [x, y];
	}
	
	function getPageScroll(){

		var yScroll;
	
		if (self.pageYOffset) {
			yScroll = self.pageYOffset;
		} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
			yScroll = document.documentElement.scrollTop;
		} else if (document.body) {// all other Explorers
			yScroll = document.body.scrollTop;
		}
	
		arrayPageScroll = new Array('',yScroll) 
		return arrayPageScroll;
	}
	
	/*
	//http://easings.net/
	
	function animation(){
		 $(this).animate({ top: '+=900'}, 1500, 'easeOutBounce');
		 $(this).animate({height:"+=100",width:"+=100",},1000,'easeOutElastic')	
	}
	*/
	
})(jQuery);
