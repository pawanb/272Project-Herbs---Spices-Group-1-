<?php
/**
 * @package    Ccomment
 * @author     DanielDimitrov <daniel@compojoom.com>
 * @date       01.05.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

JLoader::discover('ccommentTable', JPATH_ADMINISTRATOR . '/components/com_comment/tables');

/**
 * Class ccommentHelperQueue
 *
 * @since  5.0
 */
class CcommentHelperQueue
{
	/**
	 * Sends emails from the queue
	 *
	 * @param   int  $max  - how many comments?
	 *
	 * @return  void
	 */
	public static function send($max = 5)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$ids = array();

		$query->select('*')->from('#__comment_queue')->where('status = 0')
			->order('created ASC');

		$db->setQuery($query, 0, $max);

		$result = $db->loadObjectList();

		if (!empty($result))
		{
			foreach ($result as $queue)
			{
				// Send emails.
				$mail = JFactory::getMailer();
				$result = $mail->sendMail($queue->mailfrom, $queue->fromname, $queue->recipient, $queue->subject, $queue->body, 1);

				if ($result)
				{
					$ids[] = $db->q($queue->id);
				}
			}

			// Update the status to 1 == proccessed
			if (count($ids))
			{
				$query->clear();
				$query->update('#__comment_queue')->set('status=1')
					->where('id IN (' . implode(',', $ids) . ')');

				$db->setQuery($query);
				$db->execute();
			}
		}
	}

	/**
	 * Add emails to queue
	 *
	 * @param   string  $to        - to who are we sending a mail
	 * @param   string  $from      - the email
	 * @param   string  $fromName  - from name
	 * @param   string  $title     - the title of the mail
	 * @param   string  $body      - the body of the mail
	 * @param   string  $created   - the data of the mail
	 *
	 * @return void
	 */
	public static function add($to, $from, $fromName, $title, $body, $created)
	{
		$queue = JTable::getInstance('Queue', 'ccommentTable');
		$mail = array(
			'mailfrom' => $from,
			'fromname' => $fromName,
			'recipient' => $to,
			'subject' => $title,
			'body' => $body,
			'created' => $created,
			'status' => 0
		);

		$queue->bind($mail);
		$queue->store();
	}
}
