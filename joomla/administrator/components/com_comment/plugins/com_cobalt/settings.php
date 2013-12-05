<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       30.09.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Class CcommentComponentCobaltSettings
 *
 * @since  5.0.1
 */
class CcommentComponentCobaltSettings extends ccommentComponentSettings
{
	/**
	 * categories option list used to display the include/exclude category list in setting
	 * must return an array of objects (id,title)
	 *
	 * @return array() - associative array (id, title)
	 */
	public function getCategories()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id,title')->from('#__js_res_categories')->where('id > 1 AND published = 1');
		$db->setQuery($query);

		return $db->loadObjectList();
	}
}
