<?php
/***************************************************************
 *  Copyright notice
 *
 *  Copyright 2009 Daniel Dimitrov. (http://compojoom.com)
 *  All rights reserved
 *
 *  This script is part of the Compojoom Comment project. The Compojoom Comment project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');
class ccommentModelComments extends JModelList
{

	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		$component = $app->getUserStateFromRequest($this->context . '.component', 'component');
		$this->setState('filter.component', $component);

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		// List state information.
		parent::populateState('date', 'DESC');
	}

	protected function getListQuery()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('c.*, u.name as uname, u.username')->from('#__comment AS c');
		$query->leftJoin('#__users as u ON c.userid = u.id');
		$search = $this->getState('filter.search');
		if ($search)
		{
			$search = $db->Quote('%' . $db->escape($search, true) . '%');
			$query->where('(c.comment LIKE ' . $search . ' OR u.username LIKE ' . $search . ' OR u.name LIKE ' . $search
					. ' OR LOWER(c.importtable) LIKE ' . $search . ')');
		}
		$component = $this->getState('filter.component');
		if ($component)
		{
			$query->where('c.component=' . $db->q($component));
		}

		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('c.published=' . $db->q($published));
		}
		$orderCol = $this->state->get('list.ordering', 'c.date');
		$orderDirn = $this->state->get('list.direction', 'DESC');
		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	public function getComment($id)
	{
		$database = JFactory::getDBO();
		$query = 'SELECT * FROM ' . $database->qn('#__comment')
				. ' WHERE id = ' . $database->Quote($id);

		$database->setQuery($query);
		$comment = $database->loadObject();
		return $comment;
	}

}