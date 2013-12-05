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

jimport('joomla.application.component.controlleradmin');
/**
 * ccommentControllerComments
 *
 * @package        CComment
 * @subpackage     CComment
 * @since          5
 */
class ccommentControllerComments extends JControllerAdmin
{
	protected $option = 'com_comment';
	protected $text_prefix = 'COM_COMMENT';

	public function getModel($name = 'Comment', $prefix = 'ccommentModel', $config = array())
	{
		return parent::getModel($name, $prefix, $config);
	}


	public function notifypublish()
	{
		$status = $this->changeState('publish');
		$appl = JFactory::getApplication();
		if ($status)
		{
			$cid = JFactory::getApplication()->input->get('cid', array(), 'array');
			$notification = new ccommentHelperNotify($cid[0]);
			$sentemail = $notification->notify('publish');

			if ($sentemail)
			{
				$appl->enqueueMessage(JText::sprintf('COM_COMMENT_MAILTO_SENT', implode('; ',$sentemail)));
			}
			else
			{
				$appl->enqueueMessage(JText::_('COM_COMMENT_COULD_NOT_SEND_MAIL'));
			}
		}
		$this->setRedirect(JRoute::_('index.php?option=com_comment&view=comments', false));

	}


	public function notifyunpublish()
	{
		$state = $this->changeState('unpublish');
		$appl = JFactory::getApplication();

		if ($state)
		{
			$cid = JFactory::getApplication()->input->get('cid', array(), 'array');
			$notification = new ccommentHelperNotify($cid[0]);
			$sentemail = $notification->notify('unpublish');

			if ($sentemail)
			{
				$appl->enqueueMessage( JText::sprintf('COM_COMMENT_MAILTO_SENT', implode('; ',$sentemail)));
			}
			else
			{
				$appl->enqueueMessage( JText::_('COM_COMMENT_COULD_NOT_SEND_MAIL'));
			}
		}

		$this->setRedirect(Jroute::_('index.php?option=com_comment&view=comments',false));
	}

	public function changeState($task)
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		// Get items to publish from the request.
		$cid = JFactory::getApplication()->input->get('cid', array(), 'array');
		$data = array('publish' => 1, 'unpublish' => 0, 'archive' => 2, 'trash' => -2, 'report' => -3);

		$value = JArrayHelper::getValue($data, $task, 0, 'int');

		if (empty($cid))
		{
			JLog::add(JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), JLog::WARNING, 'jerror');
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			JArrayHelper::toInteger($cid);

			// Publish the items.
			if (!$model->publish($cid, $value))
			{
				JLog::add($model->getError(), JLog::WARNING, 'jerror');
				return false;
			}
			else
			{
				if ($value == 1)
				{
					$ntext = $this->text_prefix . '_N_ITEMS_PUBLISHED';
				}
				elseif ($value == 0)
				{
					$ntext = $this->text_prefix . '_N_ITEMS_UNPUBLISHED';
				}
				elseif ($value == 2)
				{
					$ntext = $this->text_prefix . '_N_ITEMS_ARCHIVED';
				}
				else
				{
					$ntext = $this->text_prefix . '_N_ITEMS_TRASHED';
				}
				$this->setMessage(JText::plural($ntext, count($cid)));
			}
		}

		return true;
	}

}