<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 11.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.viewlegacy');

class ccommentViewComments extends JViewLegacy
{

	public function display($tpl = null) {
		$app       = JFactory::getApplication();
		$doc       = JFactory::getDocument();

		$component = $app->input->getCmd('component');
		$contentId = $app->input->getInt('contentid');
		$config = ccommentConfig::getConfig($component);

		$doc->setTitle('comments');

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*, UNIX_TIMESTAMP(date) AS rss_date')
			->from('#__comment')
			->where('contentid='.$db->q($contentId))
			->where('component='.$db->q($component))
			->where('published=1');
		$query->order('date DESC');
		$db->setQuery($query , 0, 100);

		$data = $db->loadAssocList();
		if ($data != null) {
			foreach ($data as $item) {
				$rss_item = new JFeedItem();
				$rss_item->author = $item['name'];

				$rss_item->title = 'Comment #'.$item['id'];
				$rss_item->link = htmlentities(JRoute::_(JURI :: base() . "index.php?option=com_comment&task=comment.goToComment&id=" . $item['id']));
				$rss_item->description = stripslashes($item['comment']);
				$rss_item->date = date('r', $item['rss_date']);
				$doc->addItem($rss_item);
			}
		}

		echo $doc->render();
	}

}