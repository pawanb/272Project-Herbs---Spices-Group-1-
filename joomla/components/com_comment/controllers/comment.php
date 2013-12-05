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

jimport('joomla.application.component.controllerlegacy');

class ccommentControllerComment extends JControllerLegacy
{
	public function __construct($config = array()) {
		parent::__construct($config);

		$this->registerTask('unpublish', 'publish');
	}

	public function goToComment() {
		$appl = JFactory::getApplication();
		$input = $appl->input;
		$contentId = $input->getInt('contentid', '');
		$component = $input->getCmd('component', '');
		$id = null;

		if($contentId == '' && $component == '') {
			$model = $this->getModel('Comment');
			$id = $input->get('id', 0);

			if(!$id) {
				throw new Exception('Invalid comment id provided');
			}

			$comment = $model->getComment($id);

			if(!$comment) {
				throw new Exception('The comment with the provided id doesn\'t exist or was removed/unpublished');
			}

			$component = $comment->component;
			$contentId = $comment->contentid;
		}

		$plugin = ccommentHelperUtils::getPlugin($component);
		$link = ccommentHelperUtils::fixUrl($plugin->getLink($contentId, $id, false));

		$appl->redirect($link, null, 'message', 301);
	}

	public function unsubscribe() {
		$appl = JFactory::getApplication();
		$input = $appl->input;
		$id = $input->getInt('id');
		$hash = $input->getAlnum('hash');
		$email = $input->getString('mail');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('contentid, component, unsubscribe_hash')->from('#__comment')
			->where('id = ' . $db->q($id));
		$db->setQuery($query);

		$comment = $db->loadObject();

		if($comment) {
			if($comment->unsubscribe_hash === $hash) {
				$query->clear();
				$query->update('#__comment AS c')->set('c.notify = 0')
					->leftJoin('#__users AS u ON u.id = c.userid')
					->where('contentid = ' . $db->q($comment->contentid))
					->where('component = ' . $db->q($comment->component))
					->where('(c.email = ' . $db->q($email) . ' OR u.email = ' . $db->q($email) .')' );

				$db->setQuery($query);
				if($db->execute()) {
					$input->set('component', $comment->component);
					$input->set('contentid', $comment->contentid);
					$appl->enqueueMessage(JText::_('COM_COMMENT_UNSUBSCRIBE_SUCCESSFUL'));
					$this->goToComment();
				}
			}
		}

		$appl->redirect(Juri::root(), JText::_('COM_COMMENT_UNSUBSCRIBE_UNSUCCESSFUL'));
	}

	public function publish() {
		$appl = JFactory::getApplication();
		$input = $appl->input;
		$id = $input->getInt('id');
		$hash = $input->getAlnum('hash');
		$email = $input->getString('mail');
		$type = $input->getInt('type');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$commentModel = $this->getModel('Comment', 'ccommentModel');

		$comment = $commentModel->getComment($id);

		if($comment) {
			$moderatorsEmails = ccommentHelperUsers::getModeratorsEmails($comment);
			if(in_array($email, $moderatorsEmails)) {
				if($hash == $comment->moderate_hash) {
					$query->update('#__comment')->set('published = ' . $db->q($type))
						->where('id = ' . $db->q($id));
					$db->setQuery($query);
					if($db->execute()) {

						if($type) {
							$message = JText::_('COM_COMMENT_PUBLISH_SUCCESSFUL');
						} else {
							$input->set('component', $comment->component);
							$input->set('contentid', $comment->contentid);
							$message  = JText::_('COM_COMMENT_UNPUBLISH_SUCCESSFUL');
						}
						$appl->enqueueMessage($message);
						$this->goToComment();

					}
				}
			}
		}

		$appl->redirect(Juri::root(), JText::_('COM_COMMENT_COULD_NOT_UNPUBLISH'));
	}
}