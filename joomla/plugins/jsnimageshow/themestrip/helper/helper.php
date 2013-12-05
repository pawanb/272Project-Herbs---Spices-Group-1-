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

$objJSNShowcaseTheme = JSNISFactory::getObj('classes.jsn_is_showcasetheme');
$objJSNShowcaseTheme->importTableByThemeName($this->_showcaseThemeName);
$objJSNShowcaseTheme->importModelByThemeName($this->_showcaseThemeName);
$modelShowcaseTheme = JModelLegacy::getInstance($this->_showcaseThemeName);

$items = $modelShowcaseTheme->getTable($themeID);

JSNISFactory::importFile('classes.jsn_is_htmlselect');

/**
 * /////////////////////////////////////////////////////////Image Panel Begin////////////////////////////////////////////////////////////////////////////
 */
$orientation = array(
	'0' => array('value' => 'horizontal', 'text' => JText::_('THEME_STRIP_HORIZONTAL')),
	'1' => array('value' => 'vertical', 'text' => JText::_('THEME_STRIP_VERTICAL'))
);
$lists['orientation'] = JHTML::_('select.genericList', $orientation, 'image_orientation', 'class="inputbox imagePanel"', 'value', 'text', $items->image_orientation);
$imageShadow = array(
	'0' => array('value' => 'no-shadow', 'text' => JText::_('THEME_STRIP_IMAGE_NO_SHADOW')),
	'1' => array('value' => 'light-shadow', 'text' => JText::_('THEME_STRIP_IMAGE_LIGHT_SHADOW')),
	'2' => array('value' => 'bold-shadow', 'text' => JText::_('THEME_STRIP_IMAGE_BOLD_SHADOW'))
);
$lists['thumbnailShadow'] = JHTML::_('select.genericList', $imageShadow, 'image_shadow', 'class="inputbox imagePanel"', 'value', 'text', $items->image_shadow);

$imageClickAction = array(
		'0' => array('value' => 'no-action', 'text' => JText::_('THEME_STRIP_IMAGE_CLICK_ACTION_NO_ACTION')),
		'1' => array('value' => 'show-original-image', 'text' => JText::_('THEME_STRIP_IMAGE_CLICK_ACTION_SHOW_ORIGINAL_IMAGE')),
		'2' => array('value' => 'open-image-link', 'text' => JText::_('THEME_STRIP_IMAGE_CLICK_ACTION_OPEN_IMAGE_LINK'))
);

$lists['imageClickAction'] = JHTML::_('select.genericList', $imageClickAction, 'image_click_action', 'class="inputbox"', 'value', 'text', ($items->image_click_action == '') ? 'no-action' : $items->image_click_action);

$openLinkIn = array(
	'0' => array('value' => 'current_browser', 'text' => JText::_('THEME_STRIP_OPEN_LINK_IN_CURRENT_BROWSER')),
	'1' => array('value' => 'new_browser', 'text' => JText::_('THEME_STRIP_OPEN_LINK_IN_NEW_BROWSER'))
);
$lists['openLinkIn'] = JHTML::_('select.genericList', $openLinkIn, 'open_link_in', 'class="inputbox"', 'value', 'text', ($items->open_link_in == '')?'current_browser':$items->open_link_in);

$imageSource = array(
		'0' => array('value' => 'thumbnail', 'text' => JText::_('THEME_STRIP_IMAGE_SOURCE_THUMBNAIL')),
		'1' => array('value' => 'original_image', 'text' => JText::_('THEME_STRIP_IMAGE_SOURCE_ORIGINAL_IMAGE'))
);
$lists['imageSource'] = JHTML::_('select.genericList', $imageSource, 'image_source', 'class="inputbox"', 'value', 'text', ($items->image_source == '') ? 'thumbnail' : $items->image_source);

/**
 * /////////////////////////////////////////////////////////Caption Panel Begin////////////////////////////////////////////////////////////////////////////
 */

$lists['showCaption'] = JHTML::_('jsnselect.booleanlist', 'show_caption', 'class="inputbox"', $items->show_caption, 'JYES', 'JNO', false, 'yes', 'no');

$lists['captionShowTitle'] = JHTML::_('jsnselect.booleanlist', 'caption_show_title', 'class="inputbox"', $items->caption_show_title, 'JYES', 'JNO', false, 'yes', 'no');
$lists['captionShowDescription'] = JHTML::_('jsnselect.booleanlist', 'caption_show_description', 'class="inputbox"', $items->caption_show_description, 'JYES', 'JNO', false, 'yes', 'no');

/**
 * /////////////////////////////////////////////////////////Container Panel Begin////////////////////////////////////////////////////////////////////////////
 */

$containerType = array(
		'0' => array('value' => 'none', 'text' => JText::_('THEME_STRIP_NONE')),
		'1' => array('value' => 'elastislide-default', 'text' => JText::_('THEME_STRIP_ELASTISLIDE_DEFAULT')),
		'2' => array('value' => 'customize', 'text' => JText::_('THEME_STRIP_CUSTOM'))
);
$lists['containerType'] = JHTML::_('select.genericList', $containerType, 'container_type', 'class="inputbox imageContainer"', 'value', 'text', $items->container_type);

$containerSideFade = array(
		'0' => array('value' => 'none', 'text' => JText::_('THEME_STRIP_NONE')),
		'1' => array('value' => 'white', 'text' => JText::_('THEME_STRIP_ELASTISIDE_WHITE')),
		'2' => array('value' => 'black', 'text' => JText::_('THEME_STRIP_ELASTISIDE_BLACK'))
);

$lists['containerSideFade'] = JHTML::_('select.genericList', $containerSideFade, 'container_side_fade', 'class="inputbox imageContainer"', 'value', 'text', $items->container_side_fade);