<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 18.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');


class ccommentComponentHotspotsSettings extends ccommentComponentSettings
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

		$query->select('id, cat_name AS title')
			->from('#__hotspots_categorie')
			->where('published=1');

		$db->setQuery($query);
		$cats = $db->loadObjectList();

		return $cats;
	}

}