<?php
/**
 * @package - com_comment
 * @author: DanielDimitrov - compojoom.com
 * @date: 23.03.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

abstract class ccommentComponentPlugin {

	/**
	 * @param $row
	 * @param null $params - JRegistry object with config information for the item
	 */
	public function __construct($row = null, $params = null)
	{
		if($row) {
			$this->row = $row;
		}
		if($params) {
			$this->params = $params;
		}
	}

	/**
	 * With this function we determine if the comment system should be executed for this
	 * content Item
	 * @return bool
	 */
	public abstract function isEnabled();

	/**
	 * This function decides whether to show the comments
	 * in an article/item or to show the readmore link
	 *
	 * If it returns true - the comments are shown
	 * If it returns false - the showReadon function will be called
	 * @param int - the content/item id
	 * @return boolean
	 */
	public abstract function isSingleView();

	/**
	 * This function determines whether to show the comment count or not
	 * @return bool
	 */
	public abstract function showReadOn();

	/**
	 * @param int  $contentId
	 * @param int  $commentId
	 *
	 * @param bool $xhtml
	 *
	 * @return string - the URL to the comment/item
	 */
	public abstract function getLink($contentId, $commentId = 0, $xhtml = true);

	/**
	 * @param $ids - the ids of the items that we look for title
	 *
	 * @return mixed - array with objects (id, title) sorted by id
	 */
	public abstract function getItemTitles($ids);

	/**
	 * Different component have different names for the id (id, article_id, video_id etc)
	 * That is why we need a function that can reliably return the ID of the item in question
	 *
	 * @return - id of content Item
	 */
	public function getPageId()
	{
		return $this->row->id;
	}

	/**
	 * Returns the id of the author of an item
	 *
	 * @param int $contentId
	 *
	 * @return mixed
	 */
	public abstract function getAuthorId($contentId);

}