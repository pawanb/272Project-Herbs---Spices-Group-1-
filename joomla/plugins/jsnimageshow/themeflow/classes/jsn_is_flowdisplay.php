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
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
class JSNISFlowDisplay extends JObject
{
	var $_themename		= 'themeflow';
	var $_themetype		= 'jsnimageshow';
	var $_assetsPath	= 'plugins/jsnimageshow/themeflow/assets/';
	
	public function JSNISFlowDisplay() {}
	
	public function display($args)
	{
		$string 	= '';
		$args->uri	= JURI::base();
		$string .= $this->standardLayout($args);
		$string .= $this->displaySEOContent($args);
		return $string;
	}
	
	public function standardLayout($args)
	{
		$objJSNShowlist		= JSNISFactory::getObj('classes.jsn_is_showlist');
		$showlistInfo	 	= $objJSNShowlist->getShowListByID($args->showlist['showlist_id'], true);
		$dataObj			= $objJSNShowlist->getShowlist2JSON($args->uri, $args->showlist['showlist_id']);
		$images				= $dataObj->showlist->images->image;
		$document			= JFactory::getDocument();
		$plugin				= false;
		
		if (!count($images)) return '';
		
		$pluginOpenTagDiv	= '';
		$pluginCloseTagDiv	= '';
		
		if (isset($args->plugin) && $args->plugin == true)
		{
			$plugin = true;
		}
		
		switch ($showlistInfo['image_loading_order'])
		{
			case 'backward':
				krsort($images);
				$tmpImageArray = $images;
				$images = array_values($images);
				break;
			case 'random':
				shuffle($images);
				break;
			case 'forward':
				ksort($images);
		}
		
		$path = JPath::clean(JPATH_PLUGINS.DS.$this->_themetype.DS.$this->_themename.DS.'models');
		JModelLegacy::addIncludePath($path);
		$model 			= JModelLegacy::getInstance($this->_themename);
		$themeData		= $model->getTable($args->theme_id);
		$themeDataJson	= json_encode($themeData);
		JHTML::stylesheet($this->_assetsPath.'css/'.'jsn_is_flowtheme.css');
		JHTML::stylesheet($this->_assetsPath.'css/fancybox/'.'jquery.fancybox-1.3.4.css');
		JHTML::stylesheet($this->_assetsPath.'css/'.'jquery-ui-1.8.5.custom.css');
		$this->loadjQuery();
		JHTML::script($this->_assetsPath.'js/'.'jquery-ui-1.8.9.custom.js');
		JHTML::script($this->_assetsPath.'js/'.'jsn_is_conflict.js');
		if ($themeData->image_effect == 'yes') {
			$transform = 'transform';
		} else 
			$transform = '';
		$document->addScriptDeclaration('
			if (typeof jQuery.fancybox != "function") { 
				document.write(\'<script type="text\/javascript" src="'.$this->_assetsPath.'js'.'/jquery.fancybox-1.3.4.js"><\/script>\'); 
			}
			window.transform = "'.$transform.'";
		');
		JHTML::script($this->_assetsPath.'js/'.'ui.coverflow.js');
		JHTML::script($this->_assetsPath.'js/'.'sylvester.js');
		JHTML::script($this->_assetsPath.'js/'.'transformie.js');
		JHTML::script($this->_assetsPath.'js/'.'jquery.mousewheel.min.js');
		JHTML::script($this->_assetsPath.'js/'.'app.js');
		
		$imageSource	= ($themeData->image_source == 'thumbnails')?'thumbnail':'image';
		$imageLink		= ($themeData->click_action == 'show_original_image')?'image':'link';
		$openLinkIn		= ($themeData->open_link_in == 'current_browser')?'':'target="_blank"';
		$descriptionLenghtLimit	= (int) trim($themeData->caption_description_length_limitation);
		
		$wrapID			= 'jsn-'.$this->_themename.'-container-'.$args->random_number;
		$height			= (int) $args->height; 
		$css			= '#'.$wrapID.' {width:'.$args->width.';height:'.$height.'px;margin: 0 auto;position: relative;}';
		$imgHeight		= (int)$themeData->image_height;
		$imgWidth		= (int)$themeData->image_width;
		$thickness 		= (int)$themeData->image_border_thickness;
		if (!empty($imgHeight) AND !empty($imgWidth)) {
			$marginLR 	= (((260 - $imgWidth) / 2) - 35) - (int)$themeData->image_border_thickness;
			if ($transform == 'transform') {
				$marginTB 	= (($imgHeight + $thickness * 2) * 0.3) / 2;
			} else { 
				$marginTB 	= (int) $themeData->image_border_thickness*2;
			}
			$css		.= '#'.$wrapID.' #coverflow .imageItem{
				margin: '.$marginTB.'px '.$marginLR.'px;
			}';
			$css		.= '#'.$wrapID.' #coverflow img{
				height: '.$imgHeight.'px;
				width: '.$imgWidth.'px;
			}';
		}
		if ($themeData->background_type == 'solid_color') {
			$css		.= '#'.$wrapID.' .demo {
				background-color: '.$themeData->background_color.';
			}';
		} else {
			$css		.= '#'.$wrapID.' .demo {
				background: transparent;
			}';
		}
		if ($themeData->image_effect == 'yes') {
			$heightWrapper = (int) $themeData->image_height * 1.3 + ($thickness * 2) - 17;
			$css 		.= '#'.$wrapID.' .wrapper {
				height: ' . $heightWrapper . 'px;
			}';
		} else {
			$heightWrapper = (int) $themeData->image_height + ($thickness * 2);
			$css 		.= '#'.$wrapID.' .wrapper {
				height: ' . $heightWrapper . 'px;
			}';
		}
		/*if ($height > $heightWrapper) {
			$css 		.= '#'.$wrapID.' .demo {
				padding-top: ' . (($height - $heightWrapper) / 2  - 9). 'px;
			}';
		}*/
		$classFade = '';
		if ($themeData->container_side_fade != 'none') {
			$classFade = 'fade-'.$themeData->container_side_fade;
		}
		$css			.= '#'.$wrapID.' #coverflow img{
			border: '.$themeData->image_border_thickness.'px solid '.$themeData->image_border_color.';
			border-radius: '.(int)$themeData->image_border_rounded_corner.'px;
		}';
		if ($themeData->show_caption == 'yes') {
			$backgroundColor = $this->hex2rgb($themeData->caption_background_color);
			$backgroundOpacity	= (float) $themeData->caption_opacity / 100;
			$css		.= '#imageCaption {
				padding: 5px;
				background-color:rgb(' . $backgroundColor . ');background-color:rgba(' . $backgroundColor . ',' . $backgroundOpacity . ');
			}';
		}
		if ($themeData->caption_show_title == 'yes') {
			$css		.= '#imageCaption .title{
				'.$themeData->caption_title_css.';
				overflow:hidden;
			}';
		}
		if ($themeData->caption_show_description == 'yes') {
			$css		.= '#imageCaption .description{
				'.$themeData->caption_description_css.'
			}';
		}
		
		$document->addStyleDeclaration($css);
		$document->addScriptDeclaration('
		jsnThemeFlowjQuery(function() {
			jsnThemeFlowjQuery(document).ready(function () {
				var options = {"jsn_themeflow_id": "'.$wrapID.'", "jsn_themeflow_transparency" : '.$themeData->transparency.',
				"jsn_themeflow_enable_mouse_wheel" : "'.$themeData->enable_mouse_wheel_action.'",
				"jsn_themeflow_enable_keyboard_action" : "'.$themeData->enable_keyboard_action.'",
				"jsn_themeflow_click_action" : "'.$themeData->click_action.'",
				"jsn_themeflow_open_link_in" : "'.$themeData->open_link_in.'",
				"jsn_themeflow_auto_play" : "'.$themeData->auto_play.'",
				"jsn_themeflow_play_duration" : "'.$themeData->slide_timing.'",
				"jsn_themeflow_pause_over" : "'.$themeData->pause_on_mouse_over.'"};
				jsnThemeFlowjQuery.app(options);
			});
		});
		');
		
		$html = '<div id="'.$wrapID.'">';
		$html .= '<div class="demo"><div class="wrapper"><div id="coverflow">';
		foreach ($images as $image) {
			$caption = $title = $desc = '';
			if($themeData->show_caption == 'yes')
			{
				$caption	.= '<div id="imageCaption">';
				$title		= htmlspecialchars($image->title, ENT_QUOTES);
				$desc 		= '';
				if ($themeData->caption_show_title == 'yes' && $image->title != '')
				{
					$caption .= '<div class="title '.$args->random_number.'">'.$image->title.'</div>';
				}

				if($themeData->caption_show_description == 'yes' && $image->description != '')
				{
					$desc  = $this->_wordLimiter($image->description, $descriptionLenghtLimit);
					$caption .= '<div class="description '.$args->random_number.'">'.$desc.'</div>';
				}
				$caption .= '</div>';
				$caption = htmlspecialchars($caption, ENT_QUOTES);
			}
			
			if ($themeData->click_action == 'no_action')
			{
				$clickAction = '';
			}
			else
			{
				$clickAction = 'href="'.$image->$imageLink.'"';
			}
			
			$html .= '<div class="imageItem"><a '.$clickAction.' '.$openLinkIn.' title="'.$title.'" rev="'.$caption.'"><img src="'.$image->$imageSource.'" data-artist="'.$image->title.'" data-album="'.$desc.'"/></a></div>';
		}
		
		$html .= '</div>
		<div class="flow-left '.$classFade.'"></div><div class="flow-right '.$classFade.'"></div></div>
		<div id="imageDescription"></div>';
		$html .= '<div id="slider" style="display:none"></div>';
		$html .= '</div>
				<div class="demo-description">
	</div>
</div>';
		
		return $html;
	}
	
	private function _wordLimiter($str, $limit = 100, $endChar = '&#8230;')
	{
		if (trim($str) == '')
		{
		    return $str;
		}
		$append = '';
		$str 	= strip_tags(trim($str), '<b><i><s><strong><em><strike><u><br>');
		$words 	= explode(" ", $str);
		if(count($words) > $limit)
		{
			$append = $endChar;
		}

		return implode(" ", array_splice($words, 0, $limit)) . $append;
	}

	private function hex2rgb($hex) 
	{
		$hex = str_replace("#", "", $hex);
	
		if(strlen($hex) == 3) 
		{
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} 
		else 
		{
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return implode(",", $rgb); 

	}
	
	function loadjQuery()
	{
		$objUtils = JSNISFactory::getObj('classes.jsn_is_utils');

		if (method_exists($objUtils, 'loadJquery'))
		{
			$objUtils->loadJquery();
		}
		else
		{
			JHTML::script($this->_assetsPath . 'js/jsn_is_jquery_safe.js');
			JHTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
		}
	}

	function displaySEOContent($args)
	{
		$html    = '<div class="jsn-'.$this->_themename.'-seocontent">'."\n";
		if ($args->edition == 'free')
		{
			$html	.= '<p>Joomla gallery extension by <a href="http://www.joomlashine.com" title="Joomla gallery">joomlashine.com</a></p>'."\n";
		}
		if (count($args->images))
		{
			$html .= '<div>';
			$html .= '<p>' . @$args->showlist['showlist_title'] . '</p>';
			$html .= '<p>' . @$args->showlist['description'] . '</p>';
			$html .= '<ul>';

			for ($i = 0, $n = count($args->images); $i < $n; $i++)
			{
				$row 	=& $args->images[$i];
				$html  .= '<li>';
				if ($row->image_title != '')
				{
					$html .= '<p>' . $row->image_title . '</p>';
				}
				if ($row->image_description != '')
				{
					$html .= '<p>' . $row->image_description . '</p>';
				}
				if ($row->image_link != '')
				{
					$html .= '<p><a href="' . $row->image_link . '">' . $row->image_link . '</a></p>';
				}
				$html .= '</li>';
			}
			$html .= '</ul></div>';
		}
		$html	.= '</div>' . "\n";
		return $html;
	}	
}