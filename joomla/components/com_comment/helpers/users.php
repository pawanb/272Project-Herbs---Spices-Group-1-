<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       22.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Class CcommentHelperUsers
 *
 * @since  5.0
 */
class CcommentHelperUsers
{
	/**
	 * Get the user groups of the provided userIds
	 *
	 * @param   array  $userIds  - array with user ids
	 *
	 * @return array
	 */
	public static function getUserGroups($userIds)
	{
		$group = array();

		if (is_array($userIds) && count($userIds))
		{
			$db = JFactory::getDbo();

			$query = 'SELECT map.user_id, g.id as group_id, g.title '
				. 'FROM ' . $db->qn('#__usergroups') . ' AS g,'
				. $db->qn('#__user_usergroup_map') . ' AS map '
				. ' WHERE map.group_id = g.id AND user_id'
				. ' IN ( ' . implode(',', $userIds) . ')'
				. ' GROUP BY user_id, g.id';
			$db->setQuery($query);

			$userGroups = $db->loadObjectList();

			foreach ($userGroups as $value)
			{
				$group[$value->user_id][] = array(
					'group_id' => $value->group_id,
					'title' => $value->title
				);
			}
		}

		return $group;
	}

	/**
	 * Get user Ids
	 *
	 * @param   array  $comments  - get the user ids out of the comments
	 *
	 * @return array
	 */
	public static function getUserIds($comments)
	{
		$userIds = array();

		foreach ($comments as $comment)
		{
			if ($comment->userid)
			{
				$userIds[$comment->userid] = $comment->userid;
			}
		}

		return $userIds;
	}

	/**
	 * Gets all emails of the moderators for the current item/comment
	 *
	 * @param   object  $comment  - a comment object
	 *
	 * @return array|mixed
	 */
	public static function getModeratorsEmails($comment)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$config = ccommentConfig::getConfig($comment->component);
		$emails = array();
		$moderatorUsers = array();
		$moderators = $config->get('security.moderators');

		if (count($moderators))
		{
			foreach ($moderators as $group)
			{
				$users = JAccess::getUsersByGroup($group);

				if (count($users))
				{
					$moderatorUsers[] = implode(',', $users);
				}
			}

			if (count($moderatorUsers))
			{
				$query->select('DISTINCT email')
					->from('#__users')
					->where('id IN (' . implode(',', $moderatorUsers) . ')');
				$db->setQuery($query);
				$emails = $db->loadColumn();
			}
		}

		// Look for the moderator of the content item
		if ($config->get('security.content_creator'))
		{
			$contentId = $comment->contentid;
			$component = $comment->component;
			$plugin = ccommentHelperUtils::getPlugin($component);
			$author = $plugin->getAuthorId($contentId);

			if ($author)
			{
				$moderator = JFactory::getUser($author);

				if ($moderator)
				{
					$emails[] = $moderator->email;
				}
			}
		}

		// Return just unique email addresses
		return array_unique($emails);
	}
}
