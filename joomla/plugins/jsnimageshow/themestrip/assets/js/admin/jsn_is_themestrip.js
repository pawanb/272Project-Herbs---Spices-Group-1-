/**
 * @version    $Id: jquery.imageshow.js 16583 2012-10-01 11:10:07Z giangnd $
 * @package    JSN.ImageShow
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 *
 */
(function($){ 
	$.extend({
		JSNISThemeStrip: {
			
			ops:{},
			
			initialize : function (options)
			{
				$.extend(options, $.JSNISThemeStrip.ops);
				var self = $.JSNISThemeStrip;
				this.initSliderSetting("caption_opacity", 0, 100, 1, '%');
			},
			
			visual: function() {
				this.addEvent2AllVisualElements('imagePanel');
				this.addEvent2AllVisualElements('imageContainer');
			},
			
			addEvent2AllVisualElements: function(elementClass) 
			{		
				var self = $.JSNISThemeStrip;
				
				$('.' + elementClass).each(function(index, element)
				{
					var el 		= $(element);
					var event 	= 'change';
					
					if (el.attr('type') != undefined && el.attr('type') == 'radio') event = 'click';
					el.unbind(event).bind(event, function(el)
					{	
						
						self.changeValueVisualElement(elementClass, element, false);
					});
					
					self.changeValueVisualElement(elementClass, element, true);
					
				});
			},
			
			changeValueVisualElement: function(panel, element, init)
			{
				var self = $.JSNISThemeStrip;
				var el = $(element);
				var name = el.attr('name');
				
				if (el.attr('type') != undefined && el.attr('type') == 'radio')
				{
					if(el.attr("checked") != undefined && el.attr("checked") == 'checked')
					{
						var value = el.val();
					}
				}
				else
				{
					var value = el.val();
				}
				
				var obj = {name : name, value : value};
				
				self.changeVisualImage(obj, init);
				self.changeVisualImageContainer(obj, init);
			},
			
			changeVisualImage: function(obj, init) {
				var images	 			= $('.jsn-themestrip-preview-thumbnails');
				var name				= obj.name;
				var value				= obj.value;
				var self 				= $.JSNISThemeStrip;
				var orientaion 			= $('#image_orientation').val();
				var container 			= $('#jsn-themestrip-preview-container');
				var wrapper				= container.find('div.elastislide-wrapper');
				if (name == 'image_width')
				{
					images.css('width', value + 'px');
					images.find('img').css('width', value + 'px');

					$('.elastislide-vertical').css('max-width', (parseInt(value) + 10 + 2*parseInt($('#image_border').val())) + 'px');
					
				}
				else if (name == 'image_height')
				{														
					images.css('height', value + 'px');
					images.find('img').css('height', value + 'px');

					$('.elastislide-horizontal').css('height', (parseInt(value) + 10 + 2*parseInt($('#image_border').val())) + 'px');
				}	
				else if (name == 'image_space')
				{
					if (orientaion == 'vertical')
					{
						images.parent().css({'margin-bottom': value + 'px'});
						images.parent().css({'margin-right': '0px'});
					}
					else
					{	
						images.parent().css({'margin-right': value + 'px'});
						images.parent().css({'margin-bottom': '0px'});
					}
				}
				else if (name == 'image_rounded_corner')
				{
					images.css({
						'border-radius': value + 'px',
						'-moz-border-radius': value + 'px',
						'-webkit-border-radius': value + 'px'
					});					
				}
				else if (name == 'image_shadow')
				{
					switch(value)
					{
						case "no-shadow":
							images.css({
								'box-shadow' : '0px 0px 0px #888888',
								'-moz-box-shadow' : '0px 0px 0px #888888',
								'-webkit-box-shadow' : '0px 0px 0px #888888',
							}); 
							break;
						case "light-shadow":
							images.css({
								'box-shadow' : '0 0 5px rgba(0, 0, 0, 0.5)',
								'-moz-box-shadow' : '0 0 5px rgba(0, 0, 0, 0.5)',
								'-webkit-box-shadow' : '0 0 5px rgba(0, 0, 0, 0.5)',
							}); 
							break;
						case "bold-shadow":
							images.css({
								'box-shadow' : '0 0 5px rgba(0, 0, 0, 0.8)',
								'-moz-box-shadow' : '0 0 5px rgba(0, 0, 0, 0.8)',
								'-webkit-box-shadow' : '0 0 5px rgba(0, 0, 0, 0.8)',
							});
						}					
				}
				else if (name == 'image_border')
				{
					images.css('border-width', value + 'px');
					images.css('border-style', 'solid');
					$('.elastislide-vertical').css('max-width', (parseInt($('#image_width').val()) + 10 + 2*parseInt(value)) + 'px');
					$('.elastislide-horizontal').css('height', (parseInt($('#image_height').val()) + 10 + 2*parseInt(value)) + 'px');					
				}				
				else if (name == 'image_border_color')
				{
					images.css('border-color', value);
					
				}
				else if (name == 'image_orientation')
				{
					var thumbSpace 	= $('#image_space').val();
					var thumbWidth	= $('#image_width').val();
					var thumbHeight	= $('#image_height').val();
					if (value == 'vertical')
					{
						wrapper.removeClass('elastislide-horizontal').addClass('elastislide-vertical');
						$('.elastislide-vertical').css('max-width', (parseInt(thumbWidth) + 10 + 2*parseInt($('#image_border').val())) + 'px');
						$('.elastislide-vertical').css('height', '405px');	
						$('.elastislide-vertical').css('max-height', 'none');
						images.parent().css({'margin-bottom': thumbSpace + 'px'});
						images.parent().css({'margin-right': '0px'});
						if ($('#container_type').val() == 'elastislide-default')
						{	
							$('.elastislide-wrapper').removeClass('elastislide-shadow-horizontal').addClass('elastislide-shadow-vertical').removeClass('customize-elastislide-wrapper');
						}	
					}	
					else
					{
						
						wrapper.removeClass('elastislide-vertical').addClass('elastislide-horizontal');	
						$('.elastislide-horizontal').css('height', (parseInt(thumbHeight) + 10 + 2*parseInt($('#image_border').val())) + 'px');
						$('.elastislide-horizontal').css('max-width', '100%');
						images.parent().css({'margin-right': thumbSpace + 'px'});
						images.parent().css({'margin-bottom': '0px'});
						if ($('#container_type').val() == 'elastislide-default')
						{	
							$('.elastislide-wrapper').addClass('elastislide-shadow-horizontal').removeClass('elastislide-shadow-vertical').removeClass('customize-elastislide-wrapper');
						}	
					}
				}			
			},
			
			changeVisualImageContainer: function (obj, init)
			{
				var self 	= $.JSNISThemeStrip;
				var name	= obj.name;
				var value	= obj.value;
				var containerType = $('#container_type').val();
				var customizeElastislideWrapper = $('.customize-elastislide-wrapper');
				if (name == 'container_type')
				{
					if (value == 'none')
					{
						$('.elastislide-wrapper').removeClass('elastislide-shadow-horizontal').removeClass('elastislide-shadow-vertical').removeClass('customize-elastislide-wrapper');
						$('.elastislide-wrapper').css({'background-color':'', 'border-radius': '',
								'-moz-border-radius': '',
								'-webkit-border-radius': '',
								'border-color': '',
								'border-width': '',
								'border-style': ''});
						
						$('.cotainer-group').hide();
					}
					else if (value == 'elastislide-default') 
					{
						if ($('#image_orientation').val() == 'horizontal')
						{	
							$('.elastislide-wrapper').addClass('elastislide-shadow-horizontal').removeClass('elastislide-shadow-vertical').removeClass('customize-elastislide-wrapper');
						}
						else
						{
							$('.elastislide-wrapper').removeClass('elastislide-shadow-horizontal').addClass('elastislide-shadow-vertical').removeClass('customize-elastislide-wrapper');
							
						}
						$('.elastislide-wrapper').css({'background-color':'', 'border-radius': '',
								'-moz-border-radius': '',
								'-webkit-border-radius': '',
								'border-color': '',
								'border-width': '',
								'border-style': ''});
						
						$('.cotainer-group').hide();
					}
					else
					{
						$('.elastislide-wrapper').removeClass('elastislide-shadow-horizontal').removeClass('elastislide-shadow-vertical').addClass('customize-elastislide-wrapper');
						self.changeVisualSubImageContainer();
						$('.cotainer-group').show();
					}	
				}
				else if (name == 'container_background_color')
				{
					if (containerType == 'customize')
					{
						$('customize-elastislide-wrapper').css({'background-color': value});
					}	
				}	
				else if (name == 'container_round_corner')
				{
					if (containerType == 'customize')
					{	
						customizeElastislideWrapper.css({
							'border-radius': value + 'px',
							'-moz-border-radius': value + 'px',
							'-webkit-border-radius': value + 'px'
						});
					}
				}
				else if (name == 'container_border_color')
				{
					if (containerType == 'customize')
					{	
						customizeElastislideWrapper.css({
							'border-color': value
						});
					}
				}
				else if (name == 'container_border')
				{
					if (containerType == 'customize')
					{
						customizeElastislideWrapper.css('border-width', value + 'px');
						customizeElastislideWrapper.css('border-style', 'solid');
					}
				}
				else if (name == 'container_side_fade')
				{
					if(value != 'none')
					{
						if (value == 'white')
						{	
							$('.elastislide-carousel').addClass('fade-' + value).removeClass('fade-black');
						}
						else
						{
							$('.elastislide-carousel').addClass('fade-' + value).removeClass('fade-white');
						}	
						
					}
					else
					{
						$('.elastislide-carousel').removeClass('fade-white').removeClass('fade-black');
					}	
					
				}					
			},
			
			changeVisualSubImageContainer: function ()
			{
				var customizeElastislideWrapper = $('.customize-elastislide-wrapper');
				
				customizeElastislideWrapper.css({'background-color': $('#container_background_color').val()});
				
				customizeElastislideWrapper.css({
					'border-radius': $('#container_round_corner').val() + 'px',
					'-moz-border-radius': $('#container_round_corner').val() + 'px',
					'-webkit-border-radius': $('#container_round_corner').val() + 'px'
				});
					
				customizeElastislideWrapper.css({
					'border-color': $('#container_border_color').val()
				});
				
				customizeElastislideWrapper.css('border-width', $('#container_border').val() + 'px');
				customizeElastislideWrapper.css('border-style', 'solid');
			},
			
			openTab: function(panelID)
			{
				$('.' + panelID).trigger('click');
			},
			
			initSliderSetting: function(SliderElement, minVal, maxVal, stepVal, unit) 
			{
				$('#'+SliderElement+'_slider')[0].slide = null;
				$('#'+SliderElement+'_slider').slider({
					value:parseInt($('#'+SliderElement).val()),
					min: minVal,
					max: maxVal,
					step: stepVal,
					slide: function( event, ui ) {
						$('#'+SliderElement+'_slider_value').html(ui.value+unit);
						$('#'+SliderElement).val(ui.value);
						$('#'+SliderElement).trigger('change');
					}
	        	});
			}			
		}
	});
})(jQuery);