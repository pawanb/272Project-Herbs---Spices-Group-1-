<?php
/**
 * @package    - com_comment
 * @author     : DanielDimitrov - compojoom.com
 * @date: 25.03.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

class ccommentComponentK2Plugin extends ccommentComponentPlugin
{

	/**
	 * With this function we determine if the comment system should be executed for this
	 * content Item
	 * @return bool
	 */
	public function isEnabled()
	{
		$config = ccommentConfig::getConfig('com_k2');
		$row = $this->row;

		$contentIds = $config->get('basic.exclude_content_items', array());
		$categories = $config->get('basic.categories', array());
		$include = $config->get('basic.include_categories', 0);

		/* content ids */
		if (count($contentIds) > 0)
		{
			$result = in_array((($row->id == 0) ? -1 : $row->id), $contentIds);
			if ($include && $result)
			{
				return true; /* include and selected */
			}
			if (!$include && $result)
			{
				return false; /* exclude and selected */
			}
		}

		/* categories */
		$result = in_array((($row->catid == 0) ? -1 : $row->catid), $categories);
		if ($include && $result)
		{
			return true; /* include and selected */
		}
		if (!$include && $result)
		{
			return false; /* exclude and selected */
		}

		if (!$include)
		{
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
	 *
	 * @param int - the content/item id
	 *
	 * @return boolean
	 */
	public function isSingleView()
	{
		// we need to make this hack in case the plugin is called from the module
		$appl = JFactory::getApplication();
		$input = JFactory::getApplication()->input;

		if ($appl->scope == 'mod_k2_content')
		{
			return false;
		}
		$option = $input->getCmd('option', '');
		$view = $input->getCmd('view', '');
		return ($option == 'com_k2'
			&& $view == 'item'
		);
	}

	/**
	 * This function determines whether to show the comment count or not
	 * @return bool
	 */
	public function showReadOn()
	{
		$config = ccommentConfig::getConfig('com_k2');
		$params = $this->params;
		$readOn = $config->get('layout.show_readon', 0);
		$readMore = false;
		$linkTitles = false;
		if ($params != null)
		{
			$readMore = $params->get('show_readmore', 0);
			$linkTitles = $params->get('link_titles', 0);
		}

		if ($config->get('layout.menu_readon') && !$readMore)
		{
			$readOn = $params->get('userItemReadMore');
		}

		if ($config->get('layout.intro_only') && $linkTitles)
		{
			$readOn = $params->get('userItemTitleLinked');
		}

		return $readOn;
	}

	/*
     * construct the link to the content item
     * (and also direct to the comment if commentId set)
	*/
	public function getLink($contentId, $commentId = 0, $xhtml = true)
	{
		require_once(JPATH_SITE . '/components/com_k2/helpers/route.php');

		$add = '';
		if ($this->row)
		{
			$alias = $this->row->alias;
			$catid = $this->row->catid;
			$catalias = $this->row->category->alias;
		}
		else
		{
			$data = $this->getData($contentId);
			$alias = $data->alias;
			$catid = $data->catid;
			$catalias = $data->catalias;
		}

		if ($commentId)
		{
			$add = "#!/ccomment-comment=$commentId";
		}

		$url = (K2HelperRoute::getItemRoute($contentId . ':' . urlencode($alias), $catid . ':' . urlencode($catalias)));

		return JRoute::_($url . $add, $xhtml);
	}

	private function getData($id)
	{
		$database = JFactory::getDBO();
		$query = "SELECT a.alias, a.catid, c.alias as catalias FROM #__k2_items AS a "
			. ' LEFT JOIN #__k2_categories as c ON a.catid = c.id'
			. ' WHERE a.id=' . $id;
		$database->setQuery($query);
		$result = $database->loadObject();
		return $result;
	}

	/**
	 * Returns the id of the author of an item
	 *
	 * @param int $contentId
	 *
	 * @return mixed
	 */
	public function getAuthorId($contentId)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('created_by')->from('#__k2_items')
			->where('id = ' . $db->q($contentId));

		$db->setQuery($query, 0, 1);
		$author = $db->loadObject();
		if ($author)
		{
			return $author->created_by;
		}
		return false;
	}

	public function getItemTitles($ids)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id,title')->from('#__k2_items')
			->where('id IN (' . implode(',', $ids) . ')');

		$db->setQuery($query);
		return $db->loadObjectList('id');
	}
}