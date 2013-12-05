<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 30.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

class ccommentComponentMatukioPlugin extends ccommentComponentPlugin
{

	/**
	 * With this function we determine if the comment system should be executed for this
	 * content Item
	 * @return bool
	 */
	public function isEnabled()
	{
		$config = ccommentConfig::getConfig('com_matukio');
		$row = $this->row;

		$contentIds = $config->get('basic.exclude_content_items', array());
		$categories = $config->get('basic.categories', array());
		$include = $config->get('basic.include_categories', 0);

		/* content ids */
		if (count($contentIds) > 0) {
			$result = in_array((($row->id == 0) ? -1 : $row->id), $contentIds);
			if ($include && $result) {
				return true; /* include and selected */
			}
			if (!$include && $result) {
				return false; /* exclude and selected */
			}
		}

		/* categories */
		$result = in_array((($row->catid == 0) ? -1 : $row->catid), $categories);
		if ($include && $result) {
			return true; /* include and selected */
		}
		if (!$include && $result) {
			return false; /* exclude and selected */
		}

		if (!$include) {
			return true; /* was not excluded */
		}

		return false;
	}

	/**
	 * This function decides whether to show the comments
	 * in an article/item or to show the readmore link
	 *
	 * If it returns true - the comments are shown
	 * If it returns false - the setShowReadon function will be called
	 * @param int - the content/item id
	 * @return boolean
	 */
	public function isSingleView()
	{
		$input = JFactory::getApplication()->input;
		$option = $input->getCmd('option', '');
		$view = $input->getCmd('view', '');


		return ($option == 'com_matukio'
			&& $view == 'event'
		);
	}

	/**
	 * This function determines whether to show the comment count or not
	 * @return bool
	 */
	public function showReadOn()
	{
		$config = ccommentConfig::getConfig('com_matukio');
		$params = $this->params;
		$readOn = $config->get('layout.show_readon', 0);
		$readMore = false;
		$linkTitles = false;
		if ($params != null) {
			$readMore = $params->get('show_readmore', 0);
			$linkTitles = $params->get('link_titles', 0);
		}

		if ($config->get('layout.menu_readon') && !$readMore) {
			$readOn = false;
		}

		if ($config->get('layout.intro_only') && $linkTitles) {
			$readOn = false;
		}

		return $readOn;
	}

	public function getLink($contentId, $commentId = 0, $xhtml = true)
	{
		$add = '';
		// if we have a row - use the info in it
		if($this->row) {
			$event = $this->row;
			$catAlias = $event->catid . ':' . JFilterOutput::stringURLSafe($event->catalias);
			$idAlias = $contentId . ':' . JFilterOutput::stringURLSafe($event->title);
		} else {
			$event = $this->getEvent($contentId);
			$catAlias = $event->cat_id . ':' . JFilterOutput::stringURLSafe($event->cat_title);
			$idAlias = $event->id . ':' . JFilterOutput::stringURLSafe($event->title);
		}

		if($commentId) {
			$add = "#!/ccomment-comment=$commentId";
		}

		$url = JRoute::_( 'index.php?option=com_matukio&view=event&catid='.$catAlias. '&id='.$idAlias.'&art=0' . $add, $xhtml);

		return $url;
	}

	private function getEvent($id) {
		$db = JFactory::getDbo();
		$query = 'SELECT a.id, a.title, cc.id as cat_id,  cc.title as cat_title
							FROM #__matukio AS a
							LEFT JOIN #__categories AS cc ON cc.id = a.catid
							 WHERE a.id = '. $db->q($id) ;
		$db->setQuery($query);

		return $db->loadObject();
	}

	/**
	 * Returns the id of the author of an item
	 *
	 * @param int $contentId
	 *
	 * @return mixed
	 */
	public function getAuthorId($contentId) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('created_by')->from('#__matukio')
			->where('id = ' . $db->q($contentId));

		$db->setQuery($query, 0, 1);
		$author = $db->loadObject();
		if($author) {
			return $author->created_by;
		}
		return false;
	}

	public function getItemTitles($ids) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id,title')->from('#__matukio')
			->where('id IN (' . implode(',', $ids). ')');

		$db->setQuery($query);
		return $db->loadObjectList('id');
	}
}