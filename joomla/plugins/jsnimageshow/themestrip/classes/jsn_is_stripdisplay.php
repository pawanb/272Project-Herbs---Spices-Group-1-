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

jimport('joomla.application.component.model');

class JSNISStripDisplay extends JObject
{
	var $_themename 	= 'themestrip';
	var $_themetype 	= 'jsnimageshow';
	var $_assetsPath 	= 'plugins/jsnimageshow/themestrip/assets/';
	function JSNISStripDisplay() {}

	function standardLayout($args)
	{
		$objJSNShowlist	= JSNISFactory::getObj('classes.jsn_is_showlist');
		$showlistInfo 	= $objJSNShowlist->getShowListByID($args->showlist['showlist_id'], true);
		$dataObj 		= $objJSNShowlist->getShowlist2JSON($args->uri, $args->showlist['showlist_id']);
		$images			= $dataObj->showlist->images->image;
		$document 		= JFactory::getDocument();
		$plugin			= false;
		$minItems		= 3;
		if (!count($images)) return '';

		$pluginOpenTagDiv 	= '';
		$pluginCloseTagDiv 	= '';
		$containerBorder	= 0;
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

		JHTML::stylesheet($this->_assetsPath . 'css/fancybox/jquery.fancybox-1.3.4.css');
		JHTML::stylesheet($this->_assetsPath . 'css/elastislide/elastislide.css');
		JHTML::stylesheet($this->_assetsPath . 'css/elastislide/custom.css');
		JHTML::script($this->_assetsPath . 'js/jquery/modernizr.custom.17475.js');
		$this->loadjQuery();
		JHTML::script($this->_assetsPath . 'js/jsn_is_conflict.js');
		$document->addScriptDeclaration('
		if (typeof jQuery.fancybox != "function") {
			document.write(\'<script type="text\/javascript" src="'.$this->_assetsPath.'js'.'/jquery/jquery.fancybox-1.3.4.js"><\/script>\');
		}');
		JHTML::script($this->_assetsPath . 'js/jquery/jquery.elastislide.js');
		JHTML::script($this->_assetsPath . 'js/jquery/jquery.imagesloaded.min.js');
		JHTML::script($this->_assetsPath . 'js/jsn_is_themestrip.js');

		$percent  	= strpos($args->width, '%');
		if ($plugin)
		{
			$pluginOpenTagDiv 	= '<div style="max-width:'  .$args->width . ((!$percent) ? 'px' : '') . '; margin: 0 auto;">';
			$pluginCloseTagDiv 	= '</div>';
			$percent = true;
			$args->width = '100%';
		}
		$themeData 		   = $this->getThemeDataStandard($args);


		$width 			   	= ($percent === false) ? $args->width . 'px' : $args->width;

		$wrapID				= 'jsn-'.$this->_themename.'-container-'.$args->random_number;
		$galleryID			= 'jsn-'.$this->_themename.'-gallery-'.$args->random_number;
		$shadow				= '';


		$css = '#' . $wrapID . ' .elastislide-carousel ul li a img {
			border: ' . $themeData->image_border . 'px solid ' . $themeData->image_border_color . ';
		}' ."\n";

		$css .= '#' . $wrapID . ' {
			direction: ltr;
		}' ."\n";

		if ($themeData->image_orientation == 'horizontal')
		{
			$css .= '#' . $wrapID . ' .elastislide-' . $themeData->image_orientation . ' ul li a {
				padding: 0px;
				padding-right: ' . $themeData->image_space . 'px;

			}' ."\n";

			$css .= '#' . $wrapID . ' {
				max-width: ' . $width . ';
			}' ."\n";

			if ($themeData->image_shadow != 'no-shadow')
			{
				$css .= '#' . $wrapID . ' .elastislide-' . $themeData->image_orientation . ' ul {
				padding-top: 5px !important;
				padding-bottom: 5px !important;
				padding-left: 5px !important;
			}' ."\n";
			}
		}
		else
		{
			$css .= '#' . $wrapID . ' .elastislide-' . $themeData->image_orientation . ' ul li a {
				padding: 0px;
				padding-bottom: ' . $themeData->image_space . 'px;

			}' ."\n";

			$minItems = floor($args->height / $themeData->image_height);

			if ($themeData->image_shadow != 'no-shadow')
			{
				$css .= '#' . $wrapID . ' .elastislide-' . $themeData->image_orientation . ' ul {
					padding-left: 5px !important;
					padding-top: 5px !important;
				}' ."\n";
			}
		}

		$themeData->slideshow_min_items = $minItems;


		$css .= '#' . $wrapID . ' .elastislide-' . $themeData->image_orientation . ' ul li a img {

			-webkit-border-radius: ' . $themeData->image_rounded_corner . 'px;
			-moz-border-radius: ' . $themeData->image_rounded_corner . 'px;
			border-radius: ' . $themeData->image_rounded_corner . 'px;
		}' ."\n";

		switch ($themeData->image_shadow)
		{
			case 'no-shadow':
				$shadow = 'box-shadow: 0px 0px 0px #888888;
						-moz-box-shadow: 0px 0px 0px #888888;
						-webkit-box-shadow: 0px 0px 0px #888888;';
				$themeData->image_shadow = 0;
				break;
			case 'light-shadow':
				$shadow = 'box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
						moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
						-webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);';
				$themeData->image_shadow = 5;
				break;
			case 'bold-shadow':
				$shadow = 'box-shadow: 0 0 5px rgba(0, 0, 0, 0.8);
						moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.8);
						-webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.8);';
				$themeData->image_shadow = 5;
				break;
		}

		switch ($themeData->container_type)
		{
			case 'elastislide-default':
				if ($themeData->image_orientation == 'horizontal')
				{
					$css .= '#' . $wrapID . ' .elastislide-' . $themeData->image_orientation . ' {
						border-radius: 10px/90px;
						background-color: #fff;
						box-shadow: 1px 1px 3px rgba(0,0,0,0.2);
						box-shadow:
							0 1px 3px rgba(0, 0, 0, 0.1),
							inset -2px 0 3px 2px rgba(255, 255, 255, 0.6),
							inset 2px 0 3px 2px rgba(255, 255, 255, 0.6),
							inset -10px 0 10px 1px rgba(155, 155, 155, 0.1),
							inset 10px 0 10px 1px rgba(155, 155, 155, 0.1);
					}' ."\n";
				}
				else
				{
					$css .= '#' . $wrapID . ' .elastislide-' . $themeData->image_orientation . ' {
						background-color: #fff;
						box-shadow: 1px 1px 3px rgba(0,0,0,0.2);
						border-radius: 90px/10px;
						box-shadow:
						0 1px 3px rgba(0, 0, 0, 0.1),
						inset -2px 0 3px 2px rgba(255, 255, 255, 0.6),
						inset 2px 0 3px 2px rgba(255, 255, 255, 0.6),
						inset 0 -10px 10px 1px rgba(155, 155, 155, 0.1),
						inset 0 10px 10px 1px rgba(155, 155, 155, 0.1);
					}' ."\n";
				}
				break;
			case 'customize':
				$css .= '#' . $wrapID . ' .elastislide-' . $themeData->image_orientation . ' {
					background-color:' . $themeData->container_background_color . ';
					border-color:' . $themeData->container_border_color . ';
					border-width:' . $themeData->container_border .'px;
					border-style: solid;
					border-radius: ' . $themeData->container_round_corner .'px;
					-moz-border-radius: ' . $themeData->container_round_corner .'px;
					-webkit-border-radius: ' . $themeData->container_round_corner .'px
				}' ."\n";
				if ($themeData->container_border > 0)
				{
					$containerBorder = $themeData->container_border;
				}
				break;
		}

		$themeData->container_border = $containerBorder;
		$themeData->container_side_fade = $themeData->container_side_fade;
		$themeDataJson 	= json_encode($themeData);

		$css .= '#' . $wrapID . ' .elastislide-carousel ul li a img {
			' . $shadow . '
		}' ."\n";

		if($themeData->show_caption == 'yes' && ($themeData->caption_show_title == 'yes' || $themeData->caption_show_description == 'yes'))
		{
			$backgroundColor	= $this->hex2rgb($themeData->caption_background_color);
			$backgroundOpacity	= (float) $themeData->caption_opacity / 100;
			$css				.= '.jsn-themestrip-gallery-info-'.$args->random_number.' {padding:5px;display:block;background-color:rgb(' . $backgroundColor . ');background-color:rgba(' . $backgroundColor . ',' . $backgroundOpacity . ');}';
			$css				.= '.jsn-themestrip-gallery-info-title-'.$args->random_number.' {' . $themeData->caption_title_css . '}';
			$css				.= '.jsn-themestrip-gallery-info-description-'.$args->random_number.' {' . $themeData->caption_description_css . '}';
		}

		$document->addStyleDeclaration($css);

		$html  					= $pluginOpenTagDiv. '<div class="themestrip-container" id="' . $wrapID . '"><ul class="elastislide-list jsn-themestrip-container" id="' . $galleryID . '">';
		$i = 1;
		$orientation			= $themeData->image_orientation;
		$imageSource			= ($themeData->image_source == 'thumbnail') ? 'thumbnail' : 'image';

		$imageLink				= ($themeData->image_click_action == 'show-original-image') ? 'image' : 'link';
		$openLinkIn 			= ($themeData->open_link_in == 'current_browser') ? '' : 'target="_blank"';
		$descriptionLenghtLimit	= (int) trim($themeData->caption_description_length_limitation);

		foreach ($images as $image)
		{
			$caption 	= '';
			$title		= htmlspecialchars($image->title, ENT_QUOTES);

			if ($themeData->show_caption == 'yes')
			{
				if ($themeData->caption_show_title == 'yes' &&  $image->title != '')
				{
					$caption .= '<div class="jsn-themestrip-gallery-info-title-' . $args->random_number . '">' . $image->title . '</div>';
				}

				if($themeData->caption_show_description == 'yes' && $image->description != '')
				{
					$desc  		= $this->_wordLimiter($image->description, $descriptionLenghtLimit);
					$caption 	.= '<div class="jsn-themestrip-gallery-info-description-' . $args->random_number . '">' . $desc . '</div>';
				}

				$caption = htmlspecialchars($caption, ENT_QUOTES);
			}

			if ($themeData->image_click_action == 'no-action')
			{
				$imageClickAction = '';
				$openLinkIn = '';
			}
			else
			{
				$imageClickAction = 'href="' . $image->$imageLink . '"';
			}
			$html .= '<li>';
			$html .= '<a ' . $imageClickAction . ' ' . $openLinkIn . ' title="' . $title . '" rev="' . $caption . '" rel="jsn_is_striptheme_rel_' . $args->random_number . '">';
			$html .= '<img height=' . $themeData->image_height . ' width=' . $themeData->image_width . ' style="height:' . $themeData->image_height . 'px;  width:' . $themeData->image_width . 'px;" id="themestrip_img_' . $args->random_number . '_' . $i++ . '" src="' . $image->$imageSource . '" border="0" alt="' . $image->title . '"/>';
			$html .= '</a></li>';
		}
		$html .= '</ul></div>' . $pluginCloseTagDiv;
		$html .= '<script type="text/javascript">
					jsnThemeStripjQuery(function() {
						var base_height = 0;
						var base_width = 0;

						jsnThemeStripjQuery(window).load(function() {
							jsnThemeStripjQuery("#' . $galleryID . '").jsnthemestrip("'.$args->random_number.'", ' . $themeDataJson . ');

							// Get max height of theme strip items
							jsnThemeStripjQuery("#' . $galleryID . '.jsn-themestrip-container img").each(function () {
								if (jsnThemeStripjQuery(this).height() >= base_height) {
									base_height = jsnThemeStripjQuery(this).height();
									base_width = jsnThemeStripjQuery(this).width();
								}
								var self = this;
								ThumbnailImageArray=new Image();
						        ThumbnailImageArray.src=jsnThemeStripjQuery(this).attr("src");
						        ThumbnailImageArray.onload=function(){ jsnThemeStripjQuery(window).trigger("resize") };
							});
						});
						jsnThemeStripjQuery(window).resize(function () {
							var scale_width = jsnThemeStripjQuery("#' . $galleryID . '.jsn-themestrip-container img").width();
							var scale = scale_width / base_width;
							jsnThemeStripjQuery("#' . $galleryID . '.jsn-themestrip-container img").height(base_height * scale);
						});
					});
				</script>';
		return $html;
	}

	function displayAlternativeContent()
	{
		return '';
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

	function display($args)
	{
		$objUtils 	= JSNISFactory::getObj('classes.jsn_is_utils');
		$string		= '';
		$args->uri	= JURI::base();
		$string .= $this->standardLayout($args);
		$string .= $this->displaySEOContent($args);
		return $string;
	}

	function getThemeDataStandard($args)
	{
		if (is_object($args))
		{
			$path = JPath::clean(JPATH_PLUGINS . DIRECTORY_SEPARATOR . $this->_themetype . DIRECTORY_SEPARATOR . $this->_themename . DIRECTORY_SEPARATOR . 'models');
			JModelLegacy::addIncludePath($path);
			$model 					= JModelLegacy::getInstance($this->_themename);
			$themeData  			= $model->getTable($args->theme_id);
			return $themeData;
		}

		return false;
	}

	function hex2rgb($hex)
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

	function _wordLimiter($str, $limit = 100, $endChar = '&#8230;')
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
}