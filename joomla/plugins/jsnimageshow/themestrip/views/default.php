<?php
/**
 * @version    $Id$
 * @package    JSN.ImageShow - Theme.Strip
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 *
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$objJSNUtils = JSNISFactory::getObj('classes.jsn_is_utils');
$url 		 = $objJSNUtils->overrideURL();
$user 		 = JFactory::getUser();
?>
<script type="text/javascript">
	(function($) {
		$(document).ready(function(){
			$('#jsn-is-themestrip').tabs();
			$.JSNISThemeStrip.initialize();
			$.JSNISThemeStrip.visual();

			/*$('#jsn-themestrip-preview').stickyfloat({
				   duration: 0
		    });	*/

			$('#thumbnail-border-color-selector').ColorPicker({
				color: $('#image_border_color').val(),
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$('#image_border_color').val('#' + hex);
					$('#thumbnail-border-color-selector div').css('backgroundColor', '#' + hex);
					$('.jsn-themestrip-preview-thumbnails').css('border-color', '#' + hex);
				}
			});

			$('#caption-background-color-selector').ColorPicker({
				color: $('#caption_background_color').val(),
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$('#caption_background_color').val('#' + hex);
					$('#caption-background-color-selector div').css('backgroundColor', '#' + hex);
				}
			});

			$('#container-background-color-selector').ColorPicker({
				color: $('#container_background_color').val(),
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$('#container_background_color').val('#' + hex);
					$('#container-background-color-selector div').css('backgroundColor', '#' + hex);
					$('.customize-elastislide-wrapper').css('background-color', '#' + hex);
				}
			});

			$('#container-border-color-selector').ColorPicker({
				color: $('#container_border_color').val(),
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$('#container_border_color').val('#' + hex);
					$('#container-border-color-selector div').css('backgroundColor', '#' + hex);
					$('.customize-elastislide-wrapper').css('border-color', '#' + hex);
				}
			});

			$('#image_click_action').change(function() {
				if ($(this).val() == 'open-image-link') {
					$('#jsn-open-link-in').css('display', 'block');
				} else {
					$('#jsn-open-link-in').css('display', 'none');
				}
			});
			$('#image_click_action').trigger('change');	
		})
	})(jQuery);
</script>

<table class="jsn-showcase-theme-settings" style="height: 600px;">
	<tr>
		<td valign="top" id="jsn-theme-parameters-wrapper">
			<div id="jsn-is-themestrip" class="jsn-tabs">
					<ul>
						<li><a href="#themestrip-container-tab" class="themestrip-container-link-tab"><?php echo JText::_('THEME_STRIP_GENERAL_CONTAINER'); ?></a></li>
						<li><a href="#themestrip-thumbnail-tab" class="themestrip-thumbnail-link-tab"><?php echo JText::_('THEME_STRIP_IMAGE_PRESENTATION'); ?></a></li>
						<li><a href="#themestrip-caption-tab"><?php echo JText::_('THEME_STRIP_CAPTION'); ?></a></li>
						<li><a href="#themestrip-slideshow-tab"><?php echo JText::_('THEME_STRIP_SLIDESHOW_PRESENTATION'); ?></a></li>
					</ul>
					<div id="themestrip-container-tab" class="jsn-bootstrap">
						<div class="form-horizontal">
							<div class="row-fluid show-grid">
								<div class="span12">
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo JText::_('THEME_STRIP_GENERAL_TYPE_TITLE');?>::<?php echo JText::_('THEME_STRIP_GENERAL_TYPE_DESC'); ?>"><?php echo JText::_('THEME_STRIP_GENERAL_TYPE_TITLE');?></label>
										<div class="controls">
											<?php echo $lists['containerType']; ?>
										</div>
									</div>
									<div class="control-group cotainer-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_GENERAL_TITLE_OUTSITE_BACKGROUND_COLOR'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_GENERAL_DES_OUTSITE_BACKGROUND_COLOR')); ?>"><?php echo JText::_('THEME_STRIP_GENERAL_TITLE_OUTSITE_BACKGROUND_COLOR');?></label>
										<div class="controls">
											<input class="imageContainer input-mini" type="text" size="10" readonly="readonly" name="container_background_color" id="container_background_color" value="<?php echo $items->container_background_color; ?>" />
											<div class="color-selector" id="container-background-color-selector"><div style="background-color: <?php echo $items->container_background_color; ?>"></div></div>
										</div>
									</div>
									<div class="control-group cotainer-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_GENERAL_TITLE_ROUND_CORNER'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_GENERAL_DES_ROUND_CORNER')); ?>"><?php echo JText::_('THEME_STRIP_GENERAL_TITLE_ROUND_CORNER'); ?></label>
										<div class="controls">
											<input class="imageContainer input-mini" type="text" size="5" id="container_round_corner" name="container_round_corner" value="<?php echo (!empty($items->container_round_corner))?$items->container_round_corner:'0'; ?>" />&nbsp;<?php echo JText::_('px'); ?>
										</div>
									</div>
									<div class="control-group cotainer-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_GENERAL_TITLE_BORDER_STOKE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_GENERAL_DES_BORDER_STOKE')); ?>"><?php echo JText::_('THEME_STRIP_GENERAL_TITLE_BORDER_STOKE'); ?></label>
										<div class="controls">
											<input class="imageContainer input-mini" type="text" size="5"  id="container_border" name="container_border" value="<?php echo (!empty($items->container_border))?$items->container_border:'0'; ?>" />&nbsp;<?php echo JText::_('px'); ?>
										</div>
									</div>
									<div class="control-group cotainer-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_GENERAL_TITLE_BORDER_COLOR'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_GENERAL_DES_BORDER_COLOR')); ?>"><?php echo JText::_('THEME_STRIP_GENERAL_TITLE_BORDER_COLOR'); ?></label>
										<div class="controls">
											<input class="imageContainer input-mini" type="text" size="10" id="container_border_color"  name="container_border_color" value="<?php echo $items->container_border_color; ?>" />
											<div class="color-selector" id="container-border-color-selector"><div style="background-color: <?php echo $items->container_border_color; ?>"></div></div>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo JText::_('THEME_STRIP_GENERAL_SIDE_FADE_TITLE');?>::<?php echo JText::_('THEME_STRIP_GENERAL_SIDE_FADE_DESC'); ?>"><?php echo JText::_('THEME_STRIP_GENERAL_SIDE_FADE_TITLE');?></label>
										<div class="controls">
											<?php echo $lists['containerSideFade']; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="themestrip-thumbnail-tab" class="jsn-bootstrap">
						<div class="form-horizontal">
							<div class="row-fluid show-grid">
								<div class="span12">
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo JText::_('THEME_STRIP_IMAGE_SOURCE_TITLE');?>::<?php echo JText::_('THEME_STRIP_IMAGE_SOURCE_DESC'); ?>"><?php echo JText::_('THEME_STRIP_IMAGE_SOURCE_TITLE');?></label>
										<div class="controls">
											<?php echo $lists['imageSource']; ?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_ORIENTATION_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_ORIENTATION_DESC')); ?>"><?php echo JText::_('THEME_STRIP_IMAGE_ORIENTATION_TITLE');?></label>
										<div class="controls">
											<?php echo $lists['orientation']; ?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_DIMENSION_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_DIMENSION_DESC')); ?>"><?php echo JText::_('THEME_STRIP_IMAGE_DIMENSION_TITLE');?></label>
										<div class="controls">
											<input type="number" id="image_width" name="image_width" class="imagePanel input-mini" value="<?php echo $items->image_width; ?>" /> x
											<input type="number" name="image_height" id="image_height" class="imagePanel input-mini" value="<?php echo $items->image_height; ?>" /> <?php echo JText::_('THEME_STRIP_PIXEL');?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_SPACE_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_SPACE_DESC')); ?>"><?php echo JText::_('THEME_STRIP_IMAGE_SPACE_TITLE');?></label>
										<div class="controls">
											<input type="number" name="image_space" id="image_space" class="imagePanel input-mini" value="<?php echo $items->image_space; ?>" /> <?php echo JText::_('THEME_STRIP_PIXEL');?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_BORDER_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_BORDER_DESC')); ?>"><?php echo JText::_('THEME_STRIP_IMAGE_BORDER_TITLE');?></label>
										<div class="controls">
											<input type="number" name="image_border" id="image_border" class="imagePanel input-mini" value="<?php echo $items->image_border; ?>" /> <?php echo JText::_('THEME_STRIP_PIXEL');?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_ROUNDED_CORNER_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_ROUNDED_CORNER_DESC')); ?>"><?php echo JText::_('THEME_STRIP_IMAGE_ROUNDED_CORNER_TITLE');?></label>
										<div class="controls">
											<input type="number" name="image_rounded_corner" id="image_rounded_corner" class="imagePanel input-mini" value="<?php echo $items->image_rounded_corner; ?>" /> <?php echo JText::_('THEME_STRIP_PIXEL');?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_BORDER_COLOR_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_BORDER_COLOR_DESC')); ?>"><?php echo JText::_('THEME_STRIP_IMAGE_BORDER_COLOR_TITLE');?></label>
										<div class="controls">
											<input class="imagePanel input-mini" type="text" value="<?php echo (!empty($items->image_border_color))?$items->image_border_color:'#F0F0F0'; ?>" readonly="readonly" name="image_border_color" id="image_border_color" />
											<div class="color-selector" id="thumbnail-border-color-selector"><div style="background-color: <?php echo (!empty($items->image_border_color))?$items->image_border_color:'#F0F0F0'; ?>"></div></div>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_SHADOW_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_IMAGE_SHADOW_DESC')); ?>"><?php echo JText::_('THEME_STRIP_IMAGE_SHADOW_TITLE');?></label>
										<div class="controls">
											<?php echo $lists['thumbnailShadow']; ?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label hasTip" title="<?php echo JText::_('THEME_STRIP_IMAGE_CLICK_ACTION_TITLE');?>::<?php echo JText::_('THEME_STRIP_IMAGE_CLICK_ACTION_DESC'); ?>"><?php echo JText::_('THEME_STRIP_IMAGE_CLICK_ACTION_TITLE');?></label>
										<div class="controls">
											<?php echo $lists['imageClickAction']; ?>
										</div>
									</div>
									<div id="jsn-open-link-in" class="control-group">
										<label class="control-label hasTip" title="<?php echo JText::_('THEME_STRIP_OPEN_LINK_IN_TITLE');?>::<?php echo JText::_('THEME_STRIP_OPEN_LINK_IN_DESC'); ?>"><?php echo JText::_('THEME_STRIP_OPEN_LINK_IN_TITLE');?></label>
										<div class="controls">
											<?php echo $lists['openLinkIn']; ?>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
				<div id="themestrip-caption-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-carousel">
							<div class="span12">
								<div id="jsn-show-caption" class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_STRIP_SHOW_CAPTION_TITLE');?>::<?php echo JText::_('THEME_STRIP_SHOW_CAPTION_DESC'); ?>"><?php echo JText::_('THEME_STRIP_SHOW_CAPTION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['showCaption']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_CAPTION_BACKGROUND_COLOR_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_CAPTION_BACKGROUND_COLOR_DESC')); ?>"><?php echo JText::_('THEME_STRIP_CAPTION_BACKGROUND_COLOR_TITLE'); ?></label>
									<div class="controls">
										<input class="input-mini" type="text" size="10" id="caption_background_color" readonly="readonly" name="caption_background_color" value="<?php echo $items->caption_background_color; ?>" />
										<div class="color-selector" id="caption-background-color-selector"><div style="background-color: <?php echo (!empty($items->caption_background_color))?$items->caption_background_color:'#000000'; ?>"></div></div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_STRIP_CAPTION_OPACITY_TITLE');?>::<?php echo JText::_('THEME_STRIP_CAPTION_OPACITY_DESC'); ?>"><?php echo JText::_('THEME_STRIP_CAPTION_OPACITY_TITLE');?></label>
									<div class="controls">
										<input type="hidden" id="caption_opacity" name="caption_opacity" class="input-mini" value="<?php echo $items->caption_opacity; ?>" />
										<div id="caption_opacity_slider" class="strip-param-slider"></div><div id="caption_opacity_slider_value" class="strip-param-slider-value"><?php echo $items->caption_opacity; ?>%</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_STRIP_CAPTION_SHOW_TITLE_TITLE');?>::<?php echo JText::_('THEME_STRIP_CAPTION_SHOW_TITLE_DESC'); ?>"><?php echo JText::_('THEME_STRIP_CAPTION_SHOW_TITLE_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['captionShowTitle']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_CAPTION_TITLE_CSS_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_CAPTION_TITLE_CSS_DESC')); ?>"><?php echo JText::_('THEME_STRIP_CAPTION_TITLE_CSS_TITLE'); ?></label>
									<div class="controls">
										<textarea class="input-xlarge" name="caption_title_css" rows="5"><?php echo $items->caption_title_css; ?></textarea>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_STRIP_CAPTION_SHOW_DESCRIPTION_TITLE');?>::<?php echo JText::_('THEME_STRIP_CAPTION_SHOW_DESCRIPTION_DESC'); ?>"><?php echo JText::_('THEME_STRIP_CAPTION_SHOW_DESCRIPTION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['captionShowDescription']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_STRIP_CAPTION_DESCRIPTION_LENGTH_LIMITATION_TITLE');?>::<?php echo JText::_('THEME_STRIP_CAPTION_DESCRIPTION_LENGTH_LIMITATION_DESC'); ?>"><?php echo JText::_('THEME_STRIP_CAPTION_DESCRIPTION_LENGTH_LIMITATION_TITLE');?></label>
									<div class="controls">
										<input type="number" id="caption_description_length_limitation" name="caption_description_length_limitation" class="input-mini" value="<?php echo $items->caption_description_length_limitation; ?>" /> <?php echo JText::_('WORDS'); ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_CAPTION_DESCRIPTION_CSS_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_CAPTION_DESCRIPTION_CSS_DESC')); ?>"><?php echo htmlspecialchars(JText::_('THEME_STRIP_CAPTION_DESCRIPTION_CSS_TITLE'));?></label>
									<div class="controls">
										<textarea class="input-xlarge" name="caption_description_css" rows="5"><?php echo $items->caption_description_css; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="themestrip-slideshow-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-grid">
							<div class="span12">
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_STRIP_SLIDE_TIMMING_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_STRIP_SLIDE_TIMMING_DESC')); ?>"><?php echo JText::_('THEME_STRIP_SLIDE_TIMMING_TITLE'); ?></label>
									<div class="controls"><input type="text" name="slideshow_sliding_speed" value="<?php echo $items->slideshow_sliding_speed; ?>" class="slideshowPanel input-mini" size="5"> <?php echo JText::_('THEME_STRIP_MILLISECONDS');?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</td>
		<td id="jsn-theme-preview-wrapper">
			<?php include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'preview.php'; ?>
		</td>
	</tr>
</table>
<!--  important -->
<input type="hidden" name="theme_name" value="<?php echo strtolower($this->_showcaseThemeName); ?>"/>
<input type="hidden" name="theme_id" value="<?php echo (int) @$items->theme_id; ?>" />
<!--  important -->
<div style="clear:both;"></div>
