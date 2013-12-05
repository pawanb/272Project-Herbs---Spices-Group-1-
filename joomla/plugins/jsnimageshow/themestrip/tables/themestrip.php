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

class TableThemeStrip extends JTable
{
	var $theme_id 					= null;
	var $slideshow_sliding_speed	= '500';
	var $image_orientation		= 'horizontal';
	var $image_width			= '130';
	var $image_height			= '130';
	var $image_space			= '10';
	var $image_border			= '3';
	var $image_rounded_corner	= '2';
	var $image_shadow			= 'no-shadow';
	var $image_border_color		= '#eeeeee';
	var $image_click_action		= 'show-original-image';
	var $image_source			= 'thumbnail';
	var $show_caption							= 'yes';
	var $caption_background_color				= '#000000';
	var $caption_opacity						= '75';
	var $caption_show_title						= 'yes';
	var $caption_title_css						= "padding: 5px;\nfont-family: Verdana;\nfont-size: 12px;\nfont-weight: bold;\ntext-align: left;\ncolor: #E9E9E9;";
	var $caption_show_description				= 'yes';
	var $caption_description_length_limitation	= '50';
	var $caption_description_css				= "padding: 5px;\nfont-family: Arial;\nfont-size: 11px;\nfont-weight: normal;\ntext-align: left;\ncolor: #AFAFAF;";
	var $container_type							= 'elastislide-default';
	var $container_border_color					= '#cccccc';
	var $container_border						= '1';
	var $container_round_corner					= '0';
	var $container_background_color				= '#ffffff';
	var $container_side_fade					= 'white';
	var $open_link_in							= 'current_browser';
	
	function __construct(&$db)
	{
		parent::__construct('#__imageshow_theme_strip', 'theme_id', $db);
	}
}