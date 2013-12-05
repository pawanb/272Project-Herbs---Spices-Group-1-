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
class TableThemeFlow extends JTable
{
	var $theme_id								= null;
	var $image_source							= 'thumnails';
	var $image_width							= '150';
	var $image_height							= '150';
	var $image_border_thickness					= '3';
	var $image_border_rounded_corner			= '2';
	var $image_border_color						= '#eeeeee';
	var $image_effect							= 'yes';
	var $transparency							= '75';
	var $background_type						= 'solid_color';
	var $background_color						= '#ffffff';
	var $container_side_fade					= 'white';
	var $animation_duration						= '1';
	var $click_action							= 'show_original_image';
	var $open_link_in							= 'current_browser';
	var $orientation							= 'horizontal';
	var $enable_keyboard_action					= 'yes';
	var $enable_mouse_wheel_action				= 'yes';
	var $show_caption							= 'yes';
	var $caption_background_color				= '#000000';
	var $caption_opacity						= '75';
	var $caption_show_title						= 'yes';
	var $caption_title_css						= "padding: 5px;\nfont-family: Verdana;\nfont-size: 12px;\nfont-weight: bold;\ntext-align: left;\ncolor: #E9E9E9;";
	var $caption_show_description				= 'yes';
	var $caption_description_length_limitation	= '50';
	var $caption_description_css				= "padding: 5px;\nfont-family: Arial;\nfont-size: 11px;\nfont-weight: normal;\ntext-align: left;\ncolor: #AFAFAF;";
	var $auto_play								= 'no';
	var $slide_timing							= '3';
	var $pause_on_mouse_over					= 'yes';
	
	function __construct(& $db) {
		parent::__construct('#__imageshow_theme_flow', 'theme_id', $db);
	}
}