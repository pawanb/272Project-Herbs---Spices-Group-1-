<?php
/**
 * @package     Joomla.Platform
 * @subpackage  HTML
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Utility class for categories
 *
 * @package     Joomla.Platform
 * @subpackage  HTML
 * @since       11.1
 */
if (version_compare(JVERSION, '3.0.0', '<')) {
	require_once JPATH_LIBRARIES.DIRECTORY_SEPARATOR.'joomla'.DIRECTORY_SEPARATOR.'form'.DIRECTORY_SEPARATOR.'fields'.DIRECTORY_SEPARATOR.'category.php';	
} else {
	require_once JPATH_LIBRARIES.DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.'category.php';
}
 
class JFormFieldSTCategory extends JFormFieldCategory {
	 public $type = 'STCategory';
}

