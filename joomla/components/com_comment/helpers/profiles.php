<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 22.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

class ccommentHelperProfiles
{

	/**
	 * makes a profile link any of the supported systems
	 *
	 * @access public
	 *
	 * @param int $id - user id
	 * @param     $type
	 *
	 * @internal param mixed $s - user name
	 * @return string - html link to profile or just the user name if id is missing
	 */
	public static function profileLink($id = 0, $type)
	{
		if ($id == 0) {
			return '';
		}

		$profile = '';
		switch ((string)$type) {
			case 'com_comprofiler':
				$profile = self::profileLinkCB($id);
				break;
			case 'com_community':
				$profile = self::profileLinkJomSocial($id);
				break;
			case 'com_k2':
				$profile = self::profileLinkK2($id);
				break;
			case 'com_kunena':
				$profile = self::profileLinkKunena($id);
				break;
		}

		return $profile;
	}

	/**
	 * Creates a link to Community Builder profile
	 * @param int $id - user id
	 * @return string - url to profile
	 */
	private static function profileLinkCB($id)
	{
		$itemId = '';
		if (ccommentHelperUtils::getItemid('com_comprofiler')) {
			$itemId = '&Itemid=' . ccommentHelperUtils::getItemid('com_comprofiler');
		}
		$link = JRoute::_('index.php?option=com_comprofiler&task=userProfile&user=' . $id . $itemId);
		return $link;
	}

	/**
	 * Creates a link to JomSocial profile
	 * @param int $id - user id
	 * @return string - link to profile
	 */
	private static function profileLinkJomSocial($id)
	{
		$jspath = JPATH_ROOT . '/components/com_community';
		include_once($jspath . '/libraries/core.php');

		$link = CRoute::_('index.php?option=com_community&view=profile&userid=' . $id);

		return $link;
	}

	/**
	 * Creates a link to K2 profile
	 * @param int $id - user id
	 * @return string - url to profile
	 */
	private static function profileLinkK2($id)
	{
		require_once(JPATH_ROOT . '/components/com_k2/helpers/route.php');
		$link = JRoute::_(K2HelperRoute::getUserRoute($id));
		return $link;
	}

	/**
	 * Creates a link to Kunena profile
	 * @param $id
	 *
	 * @return mixed
	 */
	private static function profileLinkKunena($id) {
		JLoader::register('KunenaUserHelper', JPATH_LIBRARIES . '/kunena/user/helper.php');
		$link = KunenaUserHelper::get($id);
		return $link->getURL();
	}
}