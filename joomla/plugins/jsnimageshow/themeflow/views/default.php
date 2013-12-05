<?php
/**
 * @version     $Id$
 * @package     JSN.ImageShow
 * @subpackage  JSN.ThemeCarousel
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */
defined('_JEXEC') or die( 'Restricted access' );
$objJSNUtils = JSNISFactory::getObj('classes.jsn_is_utils');
?>
<script type="text/javascript">
(function($){
	$(document).ready(function () {
		$('#jsn-is-themeflow').tabs();
		$('.wrapper').mouseenter(function (e) {
			$(this).css('border', '2px solid #FFCD3F');
		});
		$('.wrapper').mouseleave(function (e) {
			$(this).css('border', '2px solid transparent');
		});
		$('.wrapper').click(function (e) {
			$('#jsn-is-themeflow').tabs('select', 'themeflow-container-tab');
		});
		$('#coverflow img').mouseenter(function (e) {
			var thickness = $('#image_border_thickness').val();
			$('.wrapper').css('border', '2px solid transparent');
			$(this).css('border', thickness + 'px solid #FFCD3F');
		});
		$('#coverflow img').mouseleave(function (e) {
			var thickness = $('#image_border_thickness').val();
			var border_color = $('#image_border_color').val();
			$('.wrapper').css('border', '2px solid #FFCD3F');
			$(this).css('border', thickness + 'px solid ' + border_color);
		});
		$('#coverflow img').click(function (e) {
			e.stopPropagation(); 
			$('#jsn-is-themeflow').tabs('select', 'themeflow-image-tab');
		});
	});
})(jQuery);
</script>
<table class="jsn-showcase-theme-settings" style="height:800px">
	<tr>
		<td valign="top" id="jsn-theme-parameters-wrapper">
			<div id="jsn-is-themeflow" class="jsn-tabs">
				<ul>
					<li><a href="#themeflow-container-tab"><?php echo JText::_('THEME_FLOW_CONTAINER')?></a></li>
					<li><a href="#themeflow-image-tab"><?php echo JText::_('THEME_FLOW_IMAGE')?></a></li>
					<li><a href="#themeflow-caption-tab"><?php echo JText::_('THEME_FLOW_CAPTION')?></a></li>
					<li><a href="#themeflow-navigation-tab"><?php echo JText::_('THEME_FLOW_NAVIGATION')?></a></li>
					<li><a href="#themeflow-slideshow-tab"><?php echo JText::_('THEME_FLOW_SLIDESHOW')?></a></li>
				</ul>
				<div id="themeflow-container-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-flow">
							<div class="span12">
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_CONTAINER_BACKGROUND_TYPE_TITLE');?>::<?php echo JText::_('THEME_FLOW_CONTAINER_BACKGROUND_TYPE_DESC'); ?>"><?php echo JText::_('THEME_FLOW_CONTAINER_BACKGROUND_TYPE_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['backgroundType']; ?>
									</div>
								</div>
								<div class="control-group" id="background_color_group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_CONTAINER_BACKGROUND_COLOR_TITLE');?>::<?php echo JText::_('THEME_FLOW_CONTAINER_BACKGROUND_COLOR_DESC'); ?>"><?php echo JText::_('THEME_FLOW_CONTAINER_BACKGROUND_COLOR_TITLE');?></label>
									<div class="controls">
										<input class="input-mini visual-panel" type="text" size="10" id="background_color" readonly="readonly" name="background_color" value="<?php echo $items->background_color; ?>" />
										<div class="color-selector"><div style="background-color: <?php echo (!empty($items->background_color))?$items->background_color:'#000000'; ?>"></div></div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_CONTAINER_FADE_TYPE_TITLE');?>::<?php echo JText::_('THEME_FLOW_CONTAINER_FADE_TYPE_DESC'); ?>"><?php echo JText::_('THEME_FLOW_CONTAINER_FADE_TYPE_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['containerFadeType']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="themeflow-image-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-flow">
							<div class="span12">
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_IMAGE_SOURCE_TITLE');?>::<?php echo JText::_('THEME_FLOW_IMAGE_SOURCE_DESC'); ?>"><?php echo JText::_('THEME_FLOW_IMAGE_SOURCE_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['imageSource']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_IMAGE_DIMENSION_TITLE');?>::<?php echo JText::_('THEME_FLOW_IMAGE_DIMENSION_DESC'); ?>"><?php echo JText::_('THEME_FLOW_IMAGE_DIMENSION_TITLE');?></label>
									<div class="controls">
										<input type="number" id="image_width" name="image_width" class="input-mini visual-panel" value="<?php echo $items->image_width; ?>" /> x 
										<input type="number" id="image_height" name="image_height" class="input-mini visual-panel" value="<?php echo $items->image_height; ?>" /> px
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_IMAGE_BORDER_THICKNESS_TITLE');?>::<?php echo JText::_('THEME_FLOW_IMAGE_BORDER_THICKNESS_DESC'); ?>"><?php echo JText::_('THEME_FLOW_IMAGE_BORDER_THICKNESS_TITLE');?></label>
									<div class="controls">
										<input type="number" id="image_border_thickness" name="image_border_thickness" class="input-mini visual-panel" value="<?php echo $items->image_border_thickness; ?>" /> px
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_IMAGE_BORDER_ROUNDED_CORNER_TITLE');?>::<?php echo JText::_('THEME_FLOW_IMAGE_BORDER_ROUNDED_CORNER_DESC'); ?>"><?php echo JText::_('THEME_FLOW_IMAGE_BORDER_ROUNDED_CORNER_TITLE');?></label>
									<div class="controls">
										<input type="number" id="image_border_rounded_corner" name="image_border_rounded_corner" class="input-mini visual-panel" value="<?php echo $items->image_border_rounded_corner; ?>" /> px
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_FLOW_IMAGE_BORDER_COLOR_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_FLOW_IMAGE_BORDER_COLOR_DESC')); ?>"><?php echo JText::_('THEME_FLOW_IMAGE_BORDER_COLOR_TITLE'); ?></label>
									<div class="controls">
										<input class="input-mini visual-panel" type="text" size="10" id="image_border_color" readonly="readonly" name="image_border_color" value="<?php echo $items->image_border_color; ?>" />
										<div class="color-selector"><div style="background-color: <?php echo (!empty($items->image_border_color))?$items->image_border_color:'#666666'; ?>"></div></div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_IMAGE_3D_EFFECT_TITLE');?>::<?php echo JText::_('THEME_FLOW_IMAGE_3D_EFFECT_DESC'); ?>"><?php echo JText::_('THEME_FLOW_IMAGE_3D_EFFECT_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['effects']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_TRANSPARENCY_TITLE');?>::<?php echo JText::_('THEME_FLOW_TRANSPARENCY_DESC'); ?>"><?php echo JText::_('THEME_FLOW_TRANSPARENCY_TITLE');?></label>
									<div class="controls">
										<input type="hidden" id="transparency" name="transparency" class="input-mini effect-panel" value="<?php echo $items->transparency; ?>" />
										<div id="transparency_slider" class="flow-param-slider"></div><div id="transparency_slider_value" class="flow-param-slider-value"><?php echo $items->transparency; ?>%</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_CLICK_ACTION_TITLE');?>::<?php echo JText::_('THEME_FLOW_CLICK_ACTION_DESC'); ?>"><?php echo JText::_('THEME_FLOW_CLICK_ACTION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['clickAction']; ?>
									</div>
								</div>
								<div id="jsn-open-link-in" class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_OPEN_LINK_IN_TITLE');?>::<?php echo JText::_('THEME_FLOW_OPEN_LINK_IN_DESC'); ?>"><?php echo JText::_('THEME_FLOW_OPEN_LINK_IN_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['openLinkIn']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="themeflow-caption-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-flow">
							<div class="span12">
								<div id="jsn-show-caption" class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_SHOW_CAPTION_TITLE');?>::<?php echo JText::_('THEME_FLOW_SHOW_CAPTION_DESC'); ?>"><?php echo JText::_('THEME_FLOW_SHOW_CAPTION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['showCaption']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_FLOW_CAPTION_BACKGROUND_COLOR_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_FLOW_CAPTION_BACKGROUND_COLOR_DESC')); ?>"><?php echo JText::_('THEME_FLOW_CAPTION_BACKGROUND_COLOR_TITLE'); ?></label>
									<div class="controls">
										<input class="input-mini" type="text" size="10" id="caption_background_color" readonly="readonly" name="caption_background_color" value="<?php echo $items->caption_background_color; ?>" />
										<div class="color-selector"><div style="background-color: <?php echo (!empty($items->caption_background_color))?$items->caption_background_color:'#000000'; ?>"></div></div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_CAPTION_OPACITY_TITLE');?>::<?php echo JText::_('THEME_FLOW_CAPTION_OPACITY_DESC'); ?>"><?php echo JText::_('THEME_FLOW_CAPTION_OPACITY_TITLE');?></label>
									<div class="controls">
										<input type="hidden" id="caption_opacity" name="caption_opacity" class="input-mini effect-panel" value="<?php echo $items->caption_opacity; ?>" />
										<div id="caption_opacity_slider" class="flow-param-slider"></div><div id="caption_opacity_slider_value" class="flow-param-slider-value"><?php echo $items->caption_opacity; ?>%</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_CAPTION_SHOW_TITLE_TITLE');?>::<?php echo JText::_('THEME_FLOW_CAPTION_SHOW_TITLE_DESC'); ?>"><?php echo JText::_('THEME_FLOW_CAPTION_SHOW_TITLE_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['captionShowTitle']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_FLOW_CAPTION_TITLE_CSS_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_FLOW_CAPTION_TITLE_CSS_DESC')); ?>"><?php echo JText::_('THEME_FLOW_CAPTION_TITLE_CSS_TITLE'); ?></label>
									<div class="controls">
										<textarea class="input-xlarge" name="caption_title_css" rows="5"><?php echo $items->caption_title_css; ?></textarea>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_CAPTION_SHOW_DESCRIPTION_TITLE');?>::<?php echo JText::_('THEME_FLOW_CAPTION_SHOW_DESCRIPTION_DESC'); ?>"><?php echo JText::_('THEME_FLOW_CAPTION_SHOW_DESCRIPTION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['captionShowDescription']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_CAPTION_DESCRIPTION_LENGTH_LIMITATION_TITLE');?>::<?php echo JText::_('THEME_FLOW_CAPTION_DESCRIPTION_LENGTH_LIMITATION_DESC'); ?>"><?php echo JText::_('THEME_FLOW_CAPTION_DESCRIPTION_LENGTH_LIMITATION_TITLE');?></label>
									<div class="controls">
										<input type="number" id="caption_description_length_limitation" name="caption_description_length_limitation" class="input-mini" value="<?php echo $items->caption_description_length_limitation; ?>" /> <?php echo JText::_('WORDS'); ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_FLOW_CAPTION_DESCRIPTION_CSS_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_FLOW_CAPTION_DESCRIPTION_CSS_DESC')); ?>"><?php echo htmlspecialchars(JText::_('THEME_FLOW_CAPTION_DESCRIPTION_CSS_TITLE'));?></label>
									<div class="controls">
										<textarea class="input-xlarge" name="caption_description_css" rows="5"><?php echo $items->caption_description_css; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="themeflow-navigation-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-flow">
							<div class="span12">
								<div class="control-group">
									<label style="max-width: 150px" class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_ENABLE_KEYBOARD_ACTION_TITLE');?>::<?php echo JText::_('THEME_FLOW_ENABLE_KEYBOARD_ACTION_DESC'); ?>"><?php echo JText::_('THEME_FLOW_ENABLE_KEYBOARD_ACTION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['enableKeyboardAction']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="themeflow-slideshow-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-flow">
							<div class="span12">
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_AUTO_PLAY_TITLE');?>::<?php echo JText::_('THEME_FLOW_AUTO_PLAY_DESC'); ?>"><?php echo JText::_('THEME_FLOW_AUTO_PLAY_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['autoPlay']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_SLIDE_TIMING_TITLE');?>::<?php echo JText::_('THEME_FLOW_SLIDE_TIMING_DESC'); ?>"><?php echo JText::_('THEME_FLOW_SLIDE_TIMING_TITLE');?></label>
									<div class="controls">
										<input type="number" id="slide_timing" name="slide_timing" class="input-mini effect-panel" value="<?php echo $items->slide_timing; ?>" /> <?php echo JText::_('SECONDS'); ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_FLOW_PAUSE_ON_MOUSE_OVER_TITLE');?>::<?php echo JText::_('THEME_FLOW_PAUSE_ON_MOUSE_OVER_DESC'); ?>"><?php echo JText::_('THEME_FLOW_PAUSE_ON_MOUSE_OVER_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['pauseOnMouseOver']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</td>
		<td id="jsn-preview-wrapper">
			<?php include dirname(__FILE__).DS.'preview.php'; ?>
		</td>
	</tr>
</table>
<input type="hidden" name="theme_name" value="<?php echo strtolower($this->_showcaseThemeName)?>" />
<input type="hidden" name="theme_id" value="<?php echo (int) @$items->theme_id?>" />
<div style="clear:both"></div>