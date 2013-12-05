<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 19.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

class ccommentComponentContentPlugin extends ccommentComponentPlugin
{

	/**
	 * With this function we determine if the comment system should be executed for this
	 * content Item
	 * @return bool
	 */
	public function isEnabled()
	{
		$config = ccommentConfig::getConfig('com_content');
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
		$contentId = $this->row->id;

		return ($option == 'com_content'
			&& $view == 'article'
			&& $contentId == $input->getInt('id')
		);
	}

	/**
	 * This function determines whether to show the comment count or not
	 * @return bool
	 */
	public function showReadOn()
	{
		$config = ccommentConfig::getConfig('com_content');
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
			$article = $this->row;
		} else {
			$article = $this->getArticle($contentId);
		}

		if($commentId) {
			$add = "#!/ccomment-comment=$commentId";
		}

		JLoader::import('components.com_content.helpers.route', JPATH_SITE);

		$url = JRoute::_(ContentHelperRoute::getArticleRoute(
			($article->slug),
			isset($article->catslug) ? $article->catslug : $article->catid)
			. $add, $xhtml);

		return $url;
	}

	private function getArticle($id) {
		$db = JFactory::getDbo();
		$query = 'SELECT a.*,
							CASE
								WHEN CHAR_LENGTH(a.alias)
								THEN CONCAT_WS(":", a.id, a.alias)
								ELSE a.id END as slug,
							CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias)
								ELSE cc.id END as catslug FROM #__content AS a
							LEFT JOIN #__categories AS cc ON cc.id = a.catid
							 LEFT JOIN #__users AS u ON u.id = a.created_by
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
		$query->select('created_by')->from('#__content')
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
		$query->select('id,title')->from('#__content')
			->where('id IN (' . implode(',', $ids). ')');

		$db->setQuery($query);
		return $db->loadObjectList('id');
	}
}