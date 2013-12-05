(function ($) {
	$(document).ready(function () {
		$('#transparency_slider')[0].slide = null;
		$('#transparency_slider').slider({
			value: parseInt($('#transparency').val()),
			min: 0,
			max: 100,
			step: 5,
			slide: function (event, ui) {
				$('#transparency_slider_value').html(ui.value + '%');
				$('#transparency').val(ui.value);
				$('#transparency').trigger('change');
			}
		});
		$('#caption_opacity_slider')[0].slide = null;
		$('#caption_opacity_slider').slider({
			value: parseInt($('#caption_opacity').val()),
			min: 0,
			max: 100,
			step: 5,
			slide: function (event, ui) {
				$('#caption_opacity_slider_value').html(ui.value + '%');
				$('#caption_opacity').val(ui.value);
				$('#caption_opacity').trigger('change');
			}
		});
		colorEventChange();
		initContainer();
		initImageSettings();
		initCaptionSettings();
		$('#adminForm').change(function () {
			initContainer();
			initImageSettings();
			initCaptionSettings();
		});
		$('#click_action').change(function(){
			if($(this).val() == "open_image_link")
			{
				$('#jsn-open-link-in').show();
			}
			else
			{
				$('#jsn-open-link-in').hide();
			}
		});
		$('#click_action').trigger('change'); 
		
		function initContainer() {
			var bg_type 		= $('#background_type').val();
			var bg_color		= $('#background_color').attr('value');
			var side_fade		= $('#container_side_fade').val();

			if (bg_type == 'transparent') {
				$('#background_color_group').hide();
				$('div.demo').css('background-color', 'transparent');
			} else {
				$('#background_color_group').show();
				$('div.demo').css('background-color', bg_color);
			}
			
			switch (side_fade) {
				case 'white':
					$('.flow-left').removeClass('fade-white');
					$('.flow-left').removeClass('fade-black');
					$('.flow-left').addClass('fade-white');
					$('.flow-right').removeClass('fade-white');
					$('.flow-right').removeClass('fade-black');
					$('.flow-right').addClass('fade-white');
					break;
				case 'black':
					$('.flow-left').removeClass('fade-white');
					$('.flow-left').removeClass('fade-black');
					$('.flow-left').addClass('fade-black');
					$('.flow-right').removeClass('fade-white');
					$('.flow-right').removeClass('fade-black');
					$('.flow-right').addClass('fade-black');
					break;
				default:
				case 'none':
					$('.flow-left').removeClass('fade-white');
					$('.flow-left').removeClass('fade-black');
					$('.flow-right').removeClass('fade-black');
					$('.flow-right').removeClass('fade-black');
					break;
			}
		}
		
		function initImageSettings() {
			var width 		= $('#image_width').val();
			var height 		= $('#image_height').val();
			var thickness 	= $('#image_border_thickness').val();
			var border_color 	= $('#image_border_color').val();
			var transparency	= $('#transparency').val();
			var radius			= $('#image_border_rounded_corner').val();
			var image_effect	= $('input[name="image_effect"]:checked').val();
			
			// Setter image effect
			if (image_effect == 'yes') {
				$('#coverflow img').removeClass('remove-effect');
			} else {
				$('#coverflow img').addClass('remove-effect');
			}
			// Setter width and height
			if (height != '' && width != '') {
				$('#coverflow img').css({
					'height': parseInt(height) + 'px',
					'width': parseInt(width) + 'px'
				});
				if (parseInt(width) > 0) {
					var centerSize = (parseInt($('#coverflow img').outerWidth(true)) * 5 - 190) / 2;
					var leftFlow = centerSize - (550 / 2) - 95 + 40;
					if (parseInt(width) > 150)
						$('#coverflow').css('left', '-' + leftFlow + 'px');
					else
						$('#coverflow').css('left', Math.abs(leftFlow) + 'px');
				}
				if (image_effect == 'yes') {
					var imageWrapper = parseInt(height) * 1.3 + parseInt(thickness) * 2 + 40;
					var paddingTop = (parseInt(height) * 0.3 + parseInt(thickness) * 2) / 2 + 20
					$('div.wrapper').css('height', imageWrapper + 'px');
					$('div#coverflow').css('padding-top', paddingTop + 'px');
				} else {
					var imageWrapper = parseInt(height) + parseInt(thickness) * 2 + 40;
					var paddingTop = parseInt(thickness) + 20
					$('div.wrapper').css('height', imageWrapper + 'px');
					$('div#coverflow').css('padding-top', paddingTop + 'px');
				}
			}
			// Setter border
			if (thickness != '' && (thickness - 0 > 0)) {
				$('#coverflow img').css({'border': thickness + 'px solid ' + border_color, 'margin': (10 - parseInt(thickness)) + 'px'});
			}
			// Setter border thickness
			if (radius != '' && (radius - 0 > 0)) {
				$('#coverflow img').css('border-radius', radius + 'px');
			}
			// Setter tranparency
			if (transparency != '' && (transparency - 0 >= 0)) {
				$('#coverflow .left-orient,#coverflow .right-orient').css('opacity', parseFloat(transparency)/100);
			}
		}

		function initCaptionSettings() {
			var show_caption = $('#jsn-show-caption').find('input[name="show_caption"]:checked').val();
			if (show_caption == 'yes') {
				$('#jsn-show-caption').siblings().show();
				$('#imageCaption').show();
				var caption_background_color = $('#caption_background_color').val();
				var caption_opacity = $('#caption_opacity').val();
				$('#imageCaption').css({
					'background-color': caption_background_color,
					'opacity': parseFloat(caption_opacity/100)
				});
			} else {
				$('#jsn-show-caption').siblings().hide();
				$('#imageCaption').hide();
			}
		}
		
		function colorEventChange() {
			$('.color-selector').each(function () {
				var self	= $(this);
				var colorInput = self.siblings('input').first();
				
				self.ColorPicker({
					color: $(colorInput).val(),
					onShow: function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						$(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						$(colorInput).val('#' + hex);
						self.children().css('background-color', '#' + hex);
						$(colorInput).change();
					}
				});
			});
		}
	});
})(jQuery);