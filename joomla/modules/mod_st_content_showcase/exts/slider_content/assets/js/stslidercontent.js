if (jQuery) {
		(function($){
			STContentShowcase = {}
			
			STContentShowcase.sliderContent = function(options) 
			{
				var slider = $(options.id);
				var slides = slider.find('.slides');
				var pages = slider.find('.nav span');
				
				
				setTimeout(function(){
					slides.find('.slide').each(function(){
						slide = $(this)
						if (slide.hasClass('display-none')) {
							slide.removeClass('display-none').height(slide.height()).addClass('display-none');
						} else {
							slide.height(slide.height());							
						}
					});	
				}, 1000);
				
								pages.each(function(index) {
					$(this).click(function() {
						slides.each(function(index){
							$(pages[index]).removeClass('active');
							$(this).find('.slide').each(function(index){
								var slide = $(this);
								setTimeout(function(){
									slide.addClass('display-none').removeClass("display-block");	
								}, (index + 1) * 150);
								
							});
						});
						
						$(pages[index]).addClass('active');
						$(slides[index]).find('.slide').each(function(index){
							var slide = $(this);
							setTimeout(function(){
								slide.removeClass("display-none").addClass('display-block');	
							}, (index + 1) * 150);
							
						});
					});
				});
				// var click = 0;
				// setInterval(function(){
					// $(pages[click]).trigger('click');
					// if (click == pages.length - 1){
						// click = 0;
					// } else {
						// click++;	
					// }
				// }, 3000);			}
		})(jQuery)	
}