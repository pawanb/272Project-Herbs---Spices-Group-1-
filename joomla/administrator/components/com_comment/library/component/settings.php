<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 18.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

abstract class ccommentComponentSettings
{
	/**
	 * categories option list used to display the include/exclude category list in setting
	 * must return an array of objects (id,title)
	 */
	public function getCategories()
	{
		$options = array();

		return $options;
	}

}