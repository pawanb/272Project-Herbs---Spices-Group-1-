<?php
/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date: 02.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */


defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');
class ccommentModelDashboard extends JModelList
{

	public function getLatest()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select("*")->from('#__comment')->order('date DESC');

		$db->setQuery($query, 0, 5);
		return $db->loadObjectList();
	}

	public function getStats($type) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select("COUNT('*') as count, COUNT(DISTINCT userid) as users, COUNT(DISTINCT ip) as ip, DATE(date) as date")->from('#__comment')
			->where('DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= date')
			->group('DATE(date)');


		$db->setQuery($query);

		return $db->loadObjectList();
	}

}