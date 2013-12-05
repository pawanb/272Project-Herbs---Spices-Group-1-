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
 * Class CcommentHelperSecurity
 *
 * @since  5.0
 */
class CcommentHelperSecurity
{
	/**
	 * Gets the real IP of the user
	 *
	 * @return mixed - the ip address of the user
	 */
	public static function getRealIpAddr()
	{
		/**
		 * 1. Check ip from share internet
		 * 2. to check ip pass from proxy
		 */
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	/**
	 * Check if IP is blocked
	 *
	 * @param   string  $ip  - the IP address
	 *
	 * @return bool
	 */
	public static function isBlocked($ip)
	{
		$component = JFactory::getApplication()->input->getCmd('component');
		$config = ccommentConfig::getConfig($component);

		if ($config->get('global.banlist') != '')
		{
			$ipList = explode(',', $config->get('global.banlist'));

			foreach ($ipList as $item)
			{
				if (trim($item) == $ip)
					return true;
			}
		}

		return false;
	}

	/**
	 * check if the logged in user is moderator
	 *
	 * @param   int  $contentId  - the content id
	 *
	 * @return boolean
	 */
	public static function isModerator($contentId = 0)
	{
		$user = JFactory::getUser();

		// If the user is a guest - then he is not a moderator
		if ($user->guest)
		{
			return false;
		}

		$component = JFactory::getApplication()->input->getCmd('component');
		$config = ccommentConfig::getConfig($component);
		$moderatorGroups = $config->get('security.moderators', array());
		$userGroups = $user->getAuthorisedGroups();

		// Check if the currently logged use is the creator of the content item
		// and if the content_moderator option is set to true - make him moderator
		if ($config->get('security.content_creator', 0) && $contentId)
		{
			$plugin = ccommentHelperUtils::getPlugin($component);

			if ($user->id == $plugin->getAuthorId($contentId))
			{
				return true;
			}
		}

		// Check if any of the user's groups are in the moderator's groups
		if (array_intersect($moderatorGroups, $userGroups))
		{
			return true;
		}

		return false;
	}

	/**
	 * Check if the currently logged in user has made the comment in question
	 *
	 * @param   int  $userId  - the user Id that is stored for the comment
	 *
	 * @return bool
	 */
	public static function ownComment($userId)
	{
		if ($userId)
		{
			$user = JFactory::getUser();

			if ($userId == $user->id)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks if the usergroup has access
	 *
	 * @param   array  $userGroups       - the userGroup array for the comment
	 * @param   array  $moderatorGroups  - the moderator groups
	 *
	 * @return bool
	 */
	public static function groupHasAccess($userGroups, $moderatorGroups)
	{
		if (!is_array($userGroups) || !is_array($moderatorGroups))
		{
			return false;
		}

		$groupIds = array();

		// Transform the array so that it contains only the group ids if necessary
		if (isset($userGroups[0]['group_id']))
		{
			foreach ($userGroups as $value)
			{
				$groupIds[] = $value['group_id'];
			}
		}
		else
		{
			$groupIds = $userGroups;
		}

		if (!array_intersect($moderatorGroups, $groupIds))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Checks if the comment belongs to the current user (making him a moderator for this comment)
	 *
	 * @param   int  $userId  - the user id
	 *
	 * @return boolean
	 */
	public static function isCommentModerator($userId = 0)
	{
		$user = JFactory::getUser();

		if (!$userId || $user->guest)
		{
			return false;
		}

		if ($user->id == $userId)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Restricts the moderation by time
	 *
	 * @param   string  $time  - the time in GMT
	 *
	 * @return bool
	 */
	public static function restrictModerationByTime($time)
	{
		$ago = strtotime('now') - 100 * 60;
		$date = new JDate($time);

		if ($date->toUnix() > $ago)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * This function determines if the current user is allowed to post comments
	 *
	 * @param   JRegistry  $config  - the plugin config
	 *
	 * @return bool - true if the user is allowed to post comments
	 */
	public static function canPost($config)
	{
		$user = JFactory::getUser();
		$userGroups = $user->getAuthorisedGroups();
		$postGroups = $config->get('security.authorised_users');

		// The default value for the field is 1, but it is treated from joomla as a string and not an array untill
		// the user saves the config that is why we try to set the array ourselves.
		if (is_string($postGroups) && $postGroups == 1)
		{
			$postGroups = array(1);
		}

		if (count(array_intersect($userGroups, $postGroups)))
		{
			return true;
		}

		return false;
	}
}
