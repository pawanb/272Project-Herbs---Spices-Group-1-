<?php
/***************************************************************
*  Copyright notice
*
*  Copyright 2009 Daniel Dimitrov. (http://compojoom.com)
*  All rights reserved
*
*  This script is part of the Compojoom Comment project. The Compojoom Comment project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/#

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.viewlegacy');

class ccommentViewComments extends JViewLegacy {

	public function display($tpl = null) {
		$settingsModel = JModelLegacy::getInstance('Settings', 'ccommentModel');

		$this->comments =  $this->renderComments($this->get('Items'));
		$this->state = $this->get('state');
		$this->pagination = $this->get('Pagination');

		$contentIds = $this->getContentIds($this->comments);

		foreach($contentIds as $key => $value) {
			$plugin = ccommentHelperUtils::getPlugin($key);
			$this->titles[$key] = $plugin->getItemTitles($value);
		}

		$components = $settingsModel->getItems();
		$this->componentList[] = JHtml::_('select.option', '', Jtext::_('JALL'), 'value', 'text' );
		foreach($components as $component) {
			$this->componentList[] = JHtml::_('select.option', $component->component, $component->component, 'value', 'text' );
		}

		parent::display($tpl);
	}

	private function getContentIds($comments) {
		$contentIds = array();
		foreach($comments as $comment) {
			$contentIds[$comment->component][$comment->contentid] = $comment->contentid;
		}

		return $contentIds;
	}

	private function renderComments($comments) {
		$i = 0;
		$config = JComponentHelper::getParams('com_comment');
		$length = $config->get('global.comment_length_backend', 140);

		$renderedcomments = array();
		foreach($comments as $comment) {
			if($comment->notify) {
				$notifyimg = "mailgreen.jpg";
				$notifytxt = "notify if new post " . $comment->email;
				$notifyalt = "yes";
			} else {
				$notifyimg = "mailred.jpg";
				$notifytxt = "not notify if new post " . $comment->email;
				$notifyalt = "no" ;
			}

			$img = '<img border="0" src="'.JURI::root().'media/com_comment/backend/images/'.$notifyimg .'" title="'.$notifytxt.'" alt="'.$notifyalt.'" />';
			if($comment->email) {
				$comment->notify = '<a href="mailto:'.$comment->email.'">' . $img . '</a>';
			} else {
				$comment->notify = $img;
			}

			$comment->published = JHtml::_('grid.published', $comment, $i, 'publish_g.png', 'publish_x.png', 'comments.notify');;
			$comment->delete = '<a href="javascript:return void(0);" onclick="return listItemTask(\'cb'.$i . '\',\'notifyremove\'); "><img src="'.JURI::root().'/media/com_comment/backend/images/delete_f2.png" width="12" height="12" border="0" alt="" /></a>';

			$comment->checked = JHtml::_('grid.id', $i, $comment->id);
			$comment->link = JRoute::_(Juri::root().'index.php?option=com_comment&task=comment.goToComment&id='.$comment->id);
			if (JString::strlen($comment->comment) > $length) {
				$comment->comment = JString::substr($comment->comment, 0, $length).'...';
			}
			$comment->link_edit = JRoute::_('index.php?option=com_comment&task=comment.edit&id='.$comment->id);
			if($comment->userid) {
				if($comment->uname) {
					$comment->name = $comment->uname;
				} else {
					if(!$comment->name) {
						$comment->name = JText::_('COM_COMMENT_ANONYMOUS');
					}
				}
			}

			$renderedcomments[] = $comment;
			$i++;
		}

		return $renderedcomments;
	}
}