<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       30.09.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

JLoader::register('Url', JPATH_ROOT . '/components/com_cobalt/library/php/helpers/url.php');
JLoader::register('ItemsStore', JPATH_ROOT . '/components/com_cobalt/library/php/helpers/itemsstore.php');

/**
 * Class CcommentComponentCobaltPlugin
 *
 * @since  1.0
 */
class CcommentComponentCobaltPlugin extends ccommentComponentPlugin
{
	/**
	 * With this function we determine if the comment system should be executed for this
	 * content Item
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		$config = ccommentConfig::getConfig('com_cobalt');
		$row = $this->row;

		$contentIds = $config->get('basic.exclude_content_items', array());
		$include = $config->get('basic.include_categories', 0);
		$categories = $config->get('basic.categories', array());

		// Id excluded
		if (in_array((($row->id == 0) ? -1 : $row->id), $contentIds))
		{
			return false;
		}

		// Category included or excluded
		$result = in_array((($row->category_id == 0) ? -1 : $row->category_id), $categories);

		if (($include && !$result) || (!$include && $result))
		{
			return false;
		}

		return true;
	}

	/**
	 * This function decides whether to show the comments
	 * in an article/item or to show the readmore link
	 *
	 * If it returns true - the comments are shown
	 * If it returns false - the setShowReadon function will be called
	 *
	 * @return boolean
	 */
	public function isSingleView()
	{
		$input = JFactory::getApplication()->input;
		$option = $input->getCmd('option', '');
		$view = $input->getCmd('view', '');

		return ($option == 'com_cobalt'
			&& $view == 'record'
		);
	}

	/**
	 * This function determines whether to show the comment count or not
	 *
	 * @return bool
	 */
	public function showReadOn()
	{
		$config = ccommentConfig::getConfig('com_cobalt');

		return $config->get('layout.show_readon');
	}

	/**
	 * Creates a link to a cobalt item
	 *
	 * @param   int   $contentId  - the item id
	 * @param   int   $commentId  - the comment id
	 * @param   bool  $xhtml      - should we generate a xhtml link?
	 *
	 * @return string
	 */
	public function getLink($contentId, $commentId = 0, $xhtml = true)
	{
		$add = '';

		if ($commentId)
		{
			$add = "#!/ccomment-comment=$commentId";
		}

		$url = JRoute::_(Url::record($contentId) . $add, $xhtml);

		return $url;
	}

	/**
	 * Returns the id of the author of an item
	 *
	 * @param   int  $contentId  - the content id
	 *
	 * @return mixed
	 */
	public function getAuthorId($contentId)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('user_id')->from('#__js_res_record')
			->where('id = ' . $db->q($contentId));

		$db->setQuery($query, 0, 1);
		$author = $db->loadObject();

		if ($author)
		{
			return $author->user_id;
		}

		return false;
	}

	/**
	 * Gets Cobalts record titles
	 *
	 * @param   array  $ids  - array with record ids
	 *
	 * @return mixed
	 */
	public function getItemTitles($ids)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id,title')->from('#__js_res_record')
			->where('id IN (' . implode(',', $ids) . ')');

		$db->setQuery($query);

		return $db->loadObjectList('id');
	}
}
