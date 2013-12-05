<?php
/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date       : 11.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellegacy');

/**
 * Class ccommentModelComment
 *
 * @package  CComment
 * @since    5.0
 */
class ccommentModelComment extends JModelLegacy
{
	/**
	 * Gets the comments
	 *
	 * @param   int     $contentId  - the item id for the object
	 * @param   string  $component  - the component (com_content, com_hotspots etc)
	 * @param   int     $start      - the page with comments
	 *
	 * @return array|mixed
	 */
	public function getComments($contentId, $component, $start = 0)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$settings = ccommentConfig::getConfig($component);
		$tree = $settings->get('layout.tree', 0);
		$limit = $settings->get('layout.comments_per_page', 0);

		$start = ($start != 0 && $start != 1) ? ($start - 1) * $limit : 0;

		if ($settings->get('layout.sort', 0))
		{
			$sort = 'DESC'; /* new first */
		}
		else
		{
			$sort = 'ASC'; /* last first */
		}

		$query->select('c.*, u.name AS user_realname, u.username AS user_username');
		$query->from('#__comment AS c');
		$query->leftJoin('#__users as u ON c.userid = u.id');
		$query->where('contentid=' . $db->quote($contentId));
		$query->where('component=' . $db->quote($component));

		if (!ccommentHelperSecurity::isModerator($contentId))
		{
			$query->where('published=' . $db->quote(1));
		}

		if ($tree)
		{
			$query->where('parentid<=0');
		}

		$query->order('id ' . $sort);
		$db->setQuery($query, $start, $limit);
		$comments = $db->loadObjectList();

		if ($tree)
		{
			$query->clear('where');
			$query->where('contentid=' . $db->quote($contentId));
			$query->where('component=' . $db->quote($component));
			$query->where('parentid>0');

			if (!ccommentHelperSecurity::isModerator($contentId))
			{
				$query->where('published=' . $db->quote(1));
			}

			$query->clear('order');
			$query->order('id ASC');

			// Don't change the ordering here - otherwise nested comments won't be sorted right
			$db->setQuery($query);
			$childrenComments = $db->loadObjectList();

			$comments = ($comments && count($childrenComments) > 0) ? array_merge($comments, $childrenComments) : $comments;
		}

		return $comments;
	}

	/**
	 * Gets a single comment
	 *
	 * @param   int  $id  - the id for the comment
	 *
	 * @return mixed
	 */
	public function getComment($id)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('c.*, u.username as user_username, u.name as user_realname');
		$query->from('#__comment AS c');
		$query->leftJoin('#__users AS u ON c.userid = u.id');
		$query->where('c.id = ' . $db->q($id));
		$db->setQuery($query);
		$comment = $db->loadObject();

		return $comment;
	}

	/**
	 * Function that counts the comments
	 *
	 * @param   int     $contentId   - the id of the object that we comment on
	 * @param   string  $component   - the component name
	 * @param   bool    $pagination  - should we count pagination
	 * @param   string  $filter      - any filter
	 *
	 * @return int|mixed
	 */
	public function countComments($contentId, $component, $pagination = false, $filter = '')
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('COUNT(*)')->from('#__comment')
			->where('contentid=' . $db->quote($contentId))
			->where('component=' . $db->quote($component));

		if (!ccommentHelperSecurity::isModerator($contentId))
		{
			$query->where('published=1');
		}

		if ($filter)
		{
			$query->where($filter);
		}

		if ($pagination)
		{
			$query->where('parentid=-1');
		}

		$db->setQuery($query);
		$countNumber = $db->loadResult();

		if (!$countNumber)
		{
			$countNumber = 0;
		}

		return $countNumber;
	}

	/**
	 * Load the comments on the preview page
	 *
	 * @param   int     $contentId  - the object that we comment on
	 * @param   string  $component  - the component that we comment on
	 *
	 * @return mixed
	 */
	public function getPreviewComments($contentId, $component)
	{
		$db = JFactory::getDBO();
		$settings = ccommentConfig::getConfig($component);
		$query = $db->getQuery(true);
		$query->select('*')->from('#__comment')
			->where('contentid=' . $db->quote($contentId))
			->where('component=' . $db->quote($component))
			->where('published=' . $db->quote(1))
			->order('date DESC');
		$db->setQuery($query, 0, $settings->get('template_params.preview_lines'));

		return $db->loadObjectList();
	}

	/**
	 * Stores the comment in the DB
	 *
	 * @param   array  $data  - the array with the comment
	 *
	 * @return bool
	 */
	public function insert($data)
	{
		JPluginHelper::importPlugin('compojoomcomment');
		$dispatcher = JDispatcher::getInstance();

		$table = JTable::getInstance('comment', 'ccommentTable');
		$table->bind($data);

		if (!$table->store())
		{
			return false;
		}

		$dispatcher->trigger('onAfterCommentSave', array('com_comment.comment', $table));

		return $table->id;

	}

	/**
	 * Changes the state of the comment (published, unpublished and deleted)
	 *
	 * @param   int  $state  - the new comment state
	 * @param   int  $id     - the comment id
	 *
	 * @throws Exception
	 * @return bool
	 */
	public function changeState($state, $id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		if ($state != -1)
		{
			$query->update($db->qn('#__comment'))->set($db->qn('published') . '=' . $db->q((int) $state));
		}
		else
		{
			$query->delete($db->qn('#__comment'));
		}

		$query->where($db->qn('id') . '=' . $db->q($id));

		$db->setQuery($query);

		if (!$db->query())
		{
			throw new Exception('Unable to execute query', 500);
		}

		return true;
	}

	/**
	 * @param   int  $vote  - either +1 or -1
	 * @param   int  $id    - the comment id
	 *
	 * @return bool - true if the vote was correctly processed, false otherwise
	 * @throws Exception
	 */
	public function vote($vote, $id)
	{
		if ($vote !== -1 && $vote !== 1)
		{
			throw new Exception('Invalid value provided for vote', 500);
		}

		if ($id === 0)
		{
			throw new Exception('Invalid comment id provided', 500);
		}

		$db = JFactory::getDBO();
		$query = $db->getQuery('true');

		JPluginHelper::importPlugin('compojoomcomment');
		$dispatcher = JDispatcher::getInstance();

		// Delete old votes
		$t = time() - 3 * 86400;
		$query->delete('#__comment_voting')->where($db->qn('time') . '<' . $db->q($t));
		$db->setQuery($query);
		$db->execute();

		// Check if we have a recent vote for this comment
		$query->clear();
		$query->select('COUNT(*)')->from($db->qn('#__comment_voting'))
			->where($db->qn('id') . '=' . $db->q($id))
			->where($db->qn('ip') . '=' . $db->q($_SERVER['REMOTE_ADDR']));
		$db->setQuery($query);


		$exists = $db->loadResult();

		if (!$exists)
		{
			$field = '';

			if ($vote == -1)
			{
				$field = 'voting_no';
			}
			else if ($vote == 1)
			{
				$field = 'voting_yes';
			}

			if ($field)
			{
				// Update the comment vote
				$query->clear();
				$query->update($db->qn('#__comment'))->set($db->qn($field) . '=' . $db->qn($field) . '+1')
					->where($db->qn('id') . '=' . $id);
				$db->setQuery($query);

				if (!$db->execute())
				{
					throw new Exception('Unable to update vote field', 500);
				}

				// Insert in the voting table
				$query->clear();
				$query->insert($db->qn('#__comment_voting'))->columns(array($db->qn('id'), $db->qn('ip'), $db->qn('time')))
					->values($db->q($id) . ',' . $db->q($_SERVER['REMOTE_ADDR']) . ',' . $db->q(time()));

				if (!$db->execute())
				{
					throw new Exception('Unable to insert data in voting', 500);
				}

				$dispatcher->trigger('onAfterCommentVote', array($this->getComment($id), $vote));

				return true;
			}
		}

		return false;
	}

	public function search($id, $word, $component)
	{
		$db = JFactory::getDbo();
		$db->getQuery(true);

//		$query->select('*')->from('#__comment')
//			->where()
	}

}