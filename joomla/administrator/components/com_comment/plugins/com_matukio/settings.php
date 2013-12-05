<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 18.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');


class ccommentComponentMatukioSettings extends ccommentComponentSettings
{
	/**
	 * categories option list used to display the include/exclude category list in setting
	 * must return an array of objects (id,title)
	 *
	 * @return array() - associative array (id, title)
	 */
	public function getCategories()
	{
		$db = JFactory::getDBO();

		$query = $db->getQuery(true);
		$query->select('id, title');
		$query->from('#__categories');
		$query->where('published = 1');
		$query->where('extension = ' . $db->quote('com_matukio'));
		$query->order('title ASC');

		$db->setQuery($query);
		$options = $db->loadObjectList();

		return $options;
	}

}