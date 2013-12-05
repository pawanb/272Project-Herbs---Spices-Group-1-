<?php

/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date: 02.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */


defined('_JEXEC') or die('Restricted access');

/**
 * Description of viewhtml
 *
 * @author Daniel Dimitrov
 */
jimport('joomla.application.component.viewlegacy');
class ccommentViewDashboard extends JViewLegacy
{
	public function display($tpl = null)
	{
		$model = $this->getModel();
		$stats = $model->getStats('engagement');
		$this->latest = $model->getLatest();

		$this->statsArray = array(
			array(JText::_('COM_COMMENT_DATE'), JText::_('COM_COMMENT_COMMENTS'), JText::_('COM_COMMENT_USERS'), JText::_('COM_COMMENT_USERS_IP'))
		);

		foreach ($stats as $stat)
		{
			$this->statsArray[] = array($stat->date, (int) $stat->count, (int) $stat->users, (int) $stat->ip);
		}

		parent::display($tpl);
	}
}