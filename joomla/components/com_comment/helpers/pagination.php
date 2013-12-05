<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 13.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
 
defined('_JEXEC') or die('Restricted access');

class ccommentHelperPagination {

	private $commentId;
	private $itemId;
	private $component;

	public function __construct($commentId, $itemId, $component) {
		$this->commentId = $commentId;
		$this->itemId = $itemId;
		$this->component = $component;
		$this->config = ccommentConfig::getConfig($component);
	}

	public function findPage() {
		$page = 0;
		if($this->config->get('layout.comments_per_page')) {
			$page = $this->getPage($this->commentId);
		}
		return $page;
	}


	private function getPage($commentId) {
		$model = JModelLegacy::getInstance('Comment', 'ccommentModel');
		$comment = $model->getComment($commentId);
		$page = 0;

		if($comment) {
			if($comment->parentid == -1) {
				$db = JFactory::getDbo();
				$compare = $this->config->get('layout.sort') ? '>=' : '<=';
				$filter = $db->qn('id') . $compare . $db->q($commentId);
				$count = $model->countComments($this->itemId, $this->component, true, $filter);
				$page = max(ceil($count / $this->config->get('layout.comments_per_page')), 1);
			} else {
				// try to find the parent comment again
				return $this->getPage($comment->parentid);
			}
		}

		return $page;
	}
}