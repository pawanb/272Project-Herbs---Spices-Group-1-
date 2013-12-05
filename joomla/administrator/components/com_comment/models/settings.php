<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       21.06.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

/**
 * Class ccommentModelSettings
 *
 * @since  5
 */
class CcommentModelSettings extends JModelList
{
	/**
	 * Gets the currently available plugins
	 *
	 * @return array
	 */
	public function getAvailablePlugins()
	{
		jimport('joomla.filesystem.folder');
		$folders = JFolder::folders(JPATH_COMPONENT_ADMINISTRATOR . '/plugins');

		return $folders;
	}

	/**
	 * Gets the configuration for the backend
	 *
	 * @param   string  $component  - the component name
	 *
	 * @return mixed
	 */
	public function getItem($component)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')->from($db->qn('#__comment_setting'))
			->where($db->qn('component') . '=' . $db->q($component));
		$db->setQuery($query, 0, 1);

		return $db->loadObject();
	}

	/**
	 * List query
	 *
	 * @return JDatabaseQuery
	 */
	protected function getListQuery()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')->from('#__comment_setting')->order('id, component');

		return $query;
	}
}
