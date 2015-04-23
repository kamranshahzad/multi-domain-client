(function($) {

	$.fn.MuxBanner = function(options) {

		var defaults = {
			speed : 1500,
			pause : 4000,
			transition : 'fade'
		},
		options = $.extend(defaults, options);
		
		this.each(function() {
			
			var $this = $(this);	
			var listItem 	= $this.children('li');
			var totalItems = listItem.length;
			
			$(window).load(function() {	

				$this.wrap('<div class="slider-wrap" />');	
				if (options.pause <= options.speed) options.pause = options.speed + 100;
				$this.css({
					'position' : 'relative',
					'padding' : 0
				});
			
				if (options.transition === 'slide') {
					
					$this.css({
						'width' : '9999px'
					})
					
					$this.children().css({
						'float' : 'left',
						'list-style' : 'none'
					});
				
					$('.slider-wrap').css({
						'width' : $this.children().css('width'),
						'overflow' : 'hidden'
					});
					
					slide();
				}
			
				if (options.transition === 'fade') {
					$this.children().css({
						'width' : $this.children().css('width'),
						'position' : 'absolute',
						'left' : 0
					});
				
					for(var i = $this.children().length - 1, y = 0; i >= 0; i--, y++) {
						$this.children().eq(y).css('zIndex', i + 999);
					}
				
					fade();
				}
			
				function fade() {
					setInterval(function() {
						$this.children(':first').animate({ 'opacity' : 0 }, options.speed, function() {
							$this
								.children(':first')
								.css({
									'opacity' : 1,
									'zIndex' : $this.children(':last').css('zIndex') - 1
									})
								.appendTo($this);
						});
					}, options.pause);
				}
			
				function slide() {
					setInterval(function() {
						$this.animate({ 'left' : '-' + $this.parent().css('width') }, options.speed, function() {
							$this
								.css({ 'left' : 0 })
								.children(':first')
								.appendTo($this);
						});
					}, options.pause);
				}
				
				function updateEvents(){
					alert(currentSlide);
				}
				
			}); // end window load

			
			return this;

		}); // end each

	}

})(jQuery);