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
 * Class CcommentHelperComment
 *
 * @since  5.0
 */
class CcommentHelperComment
{
	/**
	 * Manipulates the comments for output
	 *
	 * @param   array      $comments  - array with comments
	 * @param   JRegistry  $config    - the plugin configuration
	 *
	 * @return mixed
	 */
	public static function prepareComments($comments, $config)
	{
		$user = JFactory::getUser();
		$avatars = array();
		$json = array();
		$supportAvatars = $config->get('integrations.support_avatars', 0);
		$supportProfiles = $config->get('integrations.support_profiles', 0);
		$userIds = ccommentHelperUsers::getUserIds($comments);

		// This stinks...
		// TODO: find a better way to do this
		$contentId = count($comments) ? $comments[0]->contentid : 0;

		$userGroups = ccommentHelperUsers::getUserGroups($userIds);


		if ($config->get('integrations.support_avatars', 0))
		{
			$avatars = ccommentHelperAvatars::buildUserAvatars($userIds, $config->get('integrations.support_avatars', 0));
		}

		// There is no point of making a tree representation when we have just 1 comment
		if ($config->get('layout.tree', 0) && count($comments) > 1)
		{
			$comments = ccommentHelperTree::build($comments);
		}

		$bbcode = new ccommentHelperBBcode($config);

		$moderator = ccommentHelperSecurity::isModerator($contentId) &&	ccommentHelperSecurity::canPost($config);

		foreach ((array) $comments as $key => $comment)
		{
			$avatar = '';
			$class = array();
			$json[$key] = new stdClass;
			$json[$key]->id = (int) $comment->id;
			$json[$key]->parentid = (int) $comment->parentid;

			if ($comment->userid)
			{
				if ($config->get('layout.use_name', 1))
				{
					$json[$key]->name = $comment->user_realname;
				}
				else
				{
					$json[$key]->name = $comment->user_username;
				}
			}
			else
			{
				$json[$key]->name = ccommentHelperUtils::censorText($comment->name, $config);
			}

			// Censor text if necessary, convert to html output and check for words that are too long
			$json[$key]->comment = $bbcode->parse(ccommentHelperUtils::censorText($comment->comment, $config));

			if (!$moderator)
			{
				$moderator = (ccommentHelperSecurity::isCommentModerator($comment->userid) &&
					ccommentHelperSecurity::restrictModerationByTime($comment->date));
			}

			$json[$key]->commentModerator = $moderator;

			$comment->userGroups = '';

			if ($comment->userid)
			{
				if (isset($userGroups[$comment->userid]))
				{
					foreach ($userGroups[$comment->userid] as $group)
					{
						$groupName = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9 ]/', '', $group['title'])));
						$class[] = 'ccomment-' . $groupName;
					}

					$comment->userGroups = $userGroups[$comment->userid];
				}

				if ($supportAvatars)
				{
					$avatar = isset($avatars[$comment->userid]) ? $avatars[$comment->userid] : '';
				}
			}

			// If we don't have an avatar and if gravatar is enabled, let us look for an image!
			if ($avatar == '' && $config->get('integrations.gravatar', 0))
			{
				$avatar = ccommentHelperAvatars::getUserGravatar($comment->email);
			}

			// Still no avatar? Get the noAvatar image
			if ($avatar == '' && $supportAvatars)
			{
				$avatar = ccommentHelperAvatars::noAvatar();
			}

			$json[$key]->avatar = $avatar;

			$json[$key]->date = self::getLocalDate($comment->date, $config->get('layout.date_format', 'age'));
			$json[$key]->votes = (int) ($comment->voting_yes - $comment->voting_no);

			if ($supportProfiles)
			{
				$json[$key]->profileLink = ccommentHelperProfiles::profileLink($comment->userid, $supportProfiles);
			}

			$json[$key]->published = (int) $comment->published;

			if ($comment->parentid != -1)
			{
				$class[] = 'ccomment-parent-is-' . $comment->parentid;
			}

			$class[] = ($key % 2) ? 'ccomment-even' : 'ccomment-odd';
			$class[] = 'ccomment-comment';
			$class[] = (ccommentHelperSecurity::groupHasAccess($comment->userGroups, $config->get('security.moderators'))) ? 'ccomment-moderator' : '';

			if (ccommentHelperSecurity::ownComment($comment->userid))
			{
				$class[] = 'ccomment-own';
			}

			$json[$key]->class = implode(' ', $class);
		}

		return $json;
	}

	/**
	 * Prepares the comments for preview view
	 *
	 * @param   object  $plugin    - the plugin object
	 * @param   array   $comments  - array with comments
	 *
	 * @return mixed
	 */
	public static function prepareCommentForPreview($plugin, $comments)
	{
		foreach ($comments as $key => $comment)
		{
			$comments[$key]->link = ccommentHelperUtils::fixUrl($plugin->getLink($comment->contentid, $comment->id));
		}

		return $comments;
	}

	/**
	 * Function to display the Date in the right format with Offset
	 *
	 * @param   string  $strDate  - string date
	 * @param   string  $format   - string format
	 *
	 * @return string
	 */
	public static function getLocalDate($strDate, $format = 'age')
	{
		if ($format == 'age')
		{
			$formatDate = JHtml::_('date.relative', $strDate);
		}
		else
		{
			$formatDate = JHtml::_('date', $strDate, $format, true);
		}

		return $formatDate;
	}
}
