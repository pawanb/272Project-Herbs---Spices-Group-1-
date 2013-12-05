<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 01.05.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerlegacy');

class CcommentControllerQueue extends JControllerLegacy
{
	public function cron() {
		$input = JFactory::getApplication()->input;
		$total = $input->getInt( 'total', 5 );

		ccommentHelperQueue::send($total);
		echo JText::_( 'COM_COMMENT_EMAILS_PROCESSED' );
		exit;
	}
}