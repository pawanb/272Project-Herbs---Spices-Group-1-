<?php
/**
 * @package    Ccomment
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       22.02.13
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Class ccommentHelperAvatars
 *
 * @package  CComment
 * @since    5
 */
class ccommentHelperAvatars
{
	/**
	 * Gets the user avatar from a component that we support
	 *
	 * @param   int     $userId  - the user id
	 * @param   string  $type    - the component that we are going to use to get the avatar
	 *
	 * @return string
	 */
	public static function getUserAvatar($userId, $type)
	{
		$avatar = '';
		$avatars = self::buildUserAvatars(array($userId), $type);

		if (isset($avatars[$userId]))
		{
			$avatar = $avatars[$userId];
		}

		return $avatar;
	}

	/**
	 * gets the noAvatar image
	 *
	 * @return string
	 */
	public static function noAvatar()
	{
		$appl = JFactory::getApplication();
		$component = $appl->input->getCmd('component');
		$config = ccommentConfig::getConfig($component);

		$template = $config->get('template.template');
		$jTemplate = $appl->getTemplate();
		$templateMedia = JPATH_BASE . '/media/com_comment/templates/' . $template . '/images/nophoto.png';
		$templateMediaOverride = JPATH_BASE . '/templates/' . $jTemplate . '/html/com_comment/templates/' . $template . '/images/nophoto.png';

		if (is_file($templateMediaOverride))
		{
			$noAvatar = JUri::base() . 'templates/' . $jTemplate . '/html/com_comment/templates/' . $template . '/images/nophoto.png';
		}
		elseif (is_file($templateMedia))
		{
			$noAvatar = JUri::base() . 'media/com_comment/templates/' . $template . '/images/nophoto.png';
		}
		else
		{
			$noAvatar = JURI::base() . 'media/com_comment/images/noavatar.png';
		}

		return $noAvatar;
	}

	/**
	 * Gets the gravatar image
	 *
	 * @param   string  $email  - the user's email
	 *
	 * @return string - url to the gravatar image
	 */
	public static function getUserGravatar($email)
	{
		$default = self::noAvatar();
		$size = 64;

		// Prepare the gravatar image
		$path = "https://secure.gravatar.com/avatar.php?gravatar_id=" . md5(strtolower($email)) .
			"&amp;default=" . urlencode($default) . "&amp;s=" . $size;

		return $path;
	}


	/**
	 * Builds an array with all users Ids and calls the appropriate function
	 *
	 * @param   array   $userIds  - the user id
	 * @param   string  $type     - the component
	 *
	 * @return array
	 */
	public static function buildUserAvatars($userIds, $type)
	{
		$avatars = array();

		switch ((string) $type)
		{
			case 'com_comprofiler':
				$avatars = self::buildUserAvatarCB($userIds);
				break;
			case 'com_community':
				$avatars = self::buildUserAvatarJomSocial($userIds);
				break;
			case 'com_k2':
				$avatars = self::buildUserAvatarK2($userIds);
				break;
			case 'com_kunena':
				$avatars = self::buildUserAvatarKunena($userIds);
				break;
		}

		return $avatars;
	}

	/**
	 * Build an array with all avatars from JomSocial
	 *
	 * @param   array  $userIds  - array with user ids
	 *
	 * @return array
	 */
	private static function buildUserAvatarJomSocial($userIds)
	{
		$avatars = array();

		if ($userIds)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT userid, thumb FROM #__community_users WHERE userid IN (' . implode(',', $userIds) . ')';
			$db->setQuery($query);
			$userList = $db->loadAssocList();
			$avatars = array();

			foreach ($userList as $item)
			{
				if ($item['thumb'])
				{
					$avatars[$item['userid']] = JURI::base() . $item['thumb'];
				}
			}
		}

		return $avatars;
	}

	/**
	 * Build an array with all avatars from Community Builder
	 *
	 * @param   array  $userIds  - the user ids
	 *
	 * @return array
	 */
	private static function buildUserAvatarCB($userIds)
	{
		$avatars = array();

		if ($userIds)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT ' . $db->qn('u.username')
				. ',' . $db->qn('c.user_id')
				. ',' . $db->qn('c.avatar')
				. ' FROM ' . $db->qn('#__users') . 'AS u,'
				. ' ' . $db->qn('#__comprofiler') . 'AS c'
				. ' WHERE ' . $db->qn('u.id') . '=' . $db->qn('c.user_id')
				. ' AND ' . $db->qn('u.id') . ' IN (' . implode(',', $userIds) . ')';

			$db->setQuery($query);
			$userList = $db->loadAssocList();

			foreach ($userList as $item)
			{
				if ($item['avatar'])
				{
					if (JString::strpos($item['avatar'], "gallery/") === false)
					{
						$path = JURI::base() . 'images/comprofiler/tn' . $item['avatar'];
					}
					else
					{
						$path = JURI::base() . 'images/comprofiler/' . $item['avatar'];
					}

					$avatars[$item['user_id']] = $path;
				}
			}
		}

		return $avatars;
	}

	/**
	 * Gets user avatars from K2
	 *
	 * @param   array  $userIds  - array with user ids
	 *
	 * @return array
	 */
	public static function buildUserAvatarK2($userIds)
	{
		$avatars = array();

		if ($userIds)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT userID as userid, image FROM #__k2_users WHERE userid IN (' . implode(',', $userIds) . ')';
			$db->setQuery($query);
			$userList = $db->loadAssocList();

			foreach ($userList as $item)
			{
				if ($item['image'])
				{
					$avatars[$item['userid']] = JURI::root() . 'media/k2/users/' . $item['image'];
				}
			}
		}

		return $avatars;
	}

	/**
	 * Gets the users avatars from Kunena
	 *
	 * @param   array  $userIds  - array with user ids
	 *
	 * @return array
	 */
	private static function buildUserAvatarKunena($userIds)
	{
		JLoader::register('KunenaUserHelper', JPATH_LIBRARIES . '/kunena/user/helper.php');
		$avatars = array();
		$users = KunenaUserHelper::loadUsers($userIds);

		foreach ($users as $user)
		{
			$avatars[$user->userid] = $user->getAvatarURL();
		}

		return $avatars;
	}
}
