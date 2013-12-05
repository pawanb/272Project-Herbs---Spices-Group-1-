<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       28.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Class CcommentHelperNotify
 *
 * @since  5.0
 */
class CcommentHelperNotify
{
	/**
	 * The constructor
	 *
	 * @param   int  $id  - the comment id
	 */
	public function __construct($id)
	{
		$this->comment = $this->getComment($id);
		$this->config = ccommentConfig::getConfig($this->comment->component);
		$this->mailer = JFactory::getMailer();
	}

	/**
	 * Gets a comment object
	 *
	 * @param   int  $id  - comment object
	 *
	 * @return mixed
	 */
	private function getComment($id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('c.*, u.email as user_email, u.name as user_name')->from('#__comment AS c')
			->leftJoin('#__users as u ON c.userid = u.id')
			->where('c.id = ' . $db->q($id));
		$db->setQuery($query);

		return $db->loadObject();
	}

	/**
	 * Notifies the necessary users
	 *
	 * @param   string  $type          - publish/unpublish/delete
	 * @param   int     $excludeOwner  - a flag to disable the sending of the email to the author
	 *
	 * @return array
	 */
	public function notify($type, $excludeOwner = 0)
	{
		$user = JFactory::getUser();
		$users = array();
		$moderators = array();
		$sentTo = array();
		$comment = $this->comment;
		$view = $this->getView();
		$view->comment = $comment;

		if ($this->config->get('template_params.notify_users', 0))
		{
			$users = $this->getUsersForNotification();
		}

		if ($this->config->get('security.notify_moderators'))
		{
			$moderators = ccommentHelperUsers::getModeratorsEmails($comment);
		}

		if ($comment->userid)
		{
			$comment->email = $comment->user_email;
			$comment->name = $comment->user_name;
		}

		$created = JFactory::getDate()->toSql();

		// Send an email to the user only if the comment doesn't belong to the currently logged in user
		if ($comment->email && $user->get('email') !== $comment->email && $excludeOwner != 1)
		{
			if ($type == 'publish')
			{
				// Send an email to the user that made the comment
				$view->setLayout('publish_user');
				ccommentHelperQueue::add(
					$comment->email,
					$this->mailer->From,
					$this->mailer->FromName,
					JText::_('COM_COMMENT_NOTIFY_YOUR_COMMENT_HAS_BEEN_PUBLISHED'),
					$view->loadTemplate(), $created
				);
				$sentTo[] = $comment->email;
			}

			if ($type == 'unpublish')
			{
				// Send an email to the user that made the comment
				$view->setLayout('unpublish_user');
				ccommentHelperQueue::add(
					$comment->email,
					$this->mailer->From,
					$this->mailer->FromName,
					JText::_('COM_COMMENT_NOTIFY_YOUR_COMMENT_HAS_BEEN_UNPUBLISHED'),
					$view->loadTemplate(), $created
				);
				$sentTo[] = $comment->email;
			}
		}

		/**
		 * Array with all users that need to know about the comment
		 * We will exclude moderators from this list as they'll get a separate email with
		 * More options
		 */
		$users = array_diff($users, $moderators, array($comment->email));

		// Array with moderators excluding the user of the approved comment & the currently logged in user
		$moderators = array_diff($moderators, array($comment->email, $user->get('email')));

		if ($type == 'publish')
		{
			if (count($users))
			{
				$view->setLayout('publish_users');

				foreach ($users as $value)
				{
					$view->userToEmail = $value;
					ccommentHelperQueue::add(
						$value,
						$this->mailer->From,
						$this->mailer->FromName,
						JText::_('COM_COMMENT_NOTIFY_NEW_COMMENT_HAS_BEEN_MADE'),
						$view->loadTemplate(), $created
					);
				}

				$sentTo = array_merge($sentTo, $users);
			}

			if (count($moderators))
			{
				foreach ($moderators as $value)
				{
					$view->userToEmail = $value;
					$view->setLayout('publish_moderators');
					ccommentHelperQueue::add(
						$value,
						$this->mailer->From,
						$this->mailer->FromName,
						JText::_('COM_COMMENT_NOTIFY_NEW_COMMENT_HAS_BEEN_MADE_IN_TOPIC_THAT_YOU_MODERATE'),
						$view->loadTemplate(), $created
					);
				}

				$sentTo = array_merge($sentTo, $moderators);
			}
		}

		if ($type == 'unpublish')
		{
			// Users don't need to know about unpublished comments that is why we'll send a mail only to moderators
			if (count($moderators))
			{
				foreach ($moderators as $value)
				{
					$view->userToEmail = $value;
					$view->setLayout('unpublish_moderators');
					ccommentHelperQueue::add(
						$value,
						$this->mailer->From,
						$this->mailer->FromName,
						JText::_('COM_COMMENT_NOTIFY_COMMENT_HAS_BEEN_UNPUBLISHED_IN_TOPIC_THAT_YOU_MODERATE'),
						$view->loadTemplate(), $created
					);
				}

				$sentTo = array_merge($sentTo, $moderators);
			}
		}

		if ($type == 'delete')
		{
			// Users don't need to know about deleted comments that is why we'll send a mail only to moderators
			if (count($moderators))
			{
				$view->setLayout('delete_moderators');
				ccommentHelperQueue::add(
					$moderators,
					$this->mailer->From,
					$this->mailer->FromName,
					JText::_('COM_COMMENT_NOTIFY_COMMENT_HAS_BEEN_DELETED_IN_TOPIC_THAT_YOU_MODERATE'),
					$view->loadTemplate(), $created
				);
				$sentTo = array_merge($sentTo, $moderators);
			}
		}

		return array_unique($sentTo);
	}

	/**
	 * Function to notify the moderators about a new comment that needs to be published
	 *
	 * @return void
	 */
	public function notifyModerators()
	{
		$user = JFactory::getUser();
		$moderators = array();
		$sentTo = array();
		$comment = $this->comment;
		$view = $this->getView();
		$view->comment = $comment;

		$moderators = ccommentHelperUsers::getModeratorsEmails($comment);

		// Array with moderators excluding the user of the approved comment & the currently logged in user
		$moderators = array_diff($moderators, array($comment->email, $user->get('email')));

		if (count($moderators))
		{
			foreach ($moderators as $value)
			{
				$view->userToEmail = $value;
				$view->setLayout('publish_need_moderation');
				ccommentHelperQueue::add(
					$value,
					$this->mailer->From,
					$this->mailer->FromName,
					JText::_('COM_COMMENT_NOTIFY_NEW_COMMENT_HAS_BEEN_MADE_IN_TOPIC_THAT_YOU_MODERATE'),
					$view->loadTemplate(), JFactory::getDate()->toSql()
				);
			}

			$sentTo = array_merge($sentTo, $moderators);
		}
	}

	/**
	 * Get the necessary template view
	 *
	 * @return ccommentViewMails
	 */
	private function getView()
	{
		$appl = JFactory::getApplication();
		JLoader::register('ccommentViewMails', JPATH_SITE . '/components/com_comment/views/mails/view.html.php');

		$view = new ccommentViewMails(
			array(
				'base_path' => JPATH_SITE . '/components/com_comment'
			)
		);

		// If we are in the backend we need to add the correct way to the override for the mails
		if ($appl->isAdmin())
		{
			$view->addTemplatePath(JPATH_SITE . '/templates/' . ccommentHelperTemplate::getFrontendTemplate() . '/html/com_comment/mails');
		}

		return $view;
	}

	/**
	 * Gets all users (unregistered & registered that should get a notification)
	 *
	 * @return array
	 */
	private function getUsersForNotification()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('DISTINCT email')->from('#__comment')
			->where('contentid = ' . $db->q($this->comment->contentid))
			->where('component = ' . $db->q($this->comment->component))
			->where('userid = 0')
			->where('email <> ""')
			->where('notify = 1');

		$db->setQuery($query);

		$unregistered = $db->loadColumn();

		$query->clear();
		$query->select('DISTINCT u.email')
			->from('#__comment AS c')
			->leftJoin('#__users AS u ON u.id = c.userid')
			->where('c.contentid = ' . $db->q($this->comment->contentid))
			->where('c.component = ' . $db->q($this->comment->component))
			->where('u.email <> ""')
			->where('c.notify = 1');
		$db->setQuery($query);
		$registered = $db->loadColumn();

		$emails = array_merge($unregistered, $registered);

		return $emails;
	}
}
