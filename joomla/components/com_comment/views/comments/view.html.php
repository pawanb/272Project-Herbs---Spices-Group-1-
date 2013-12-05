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
		$appl = JFactory::getApplication();
		$user = JFactory::getUser();
		$commentTemplate = $this->config->get('template.template', 'default');
		$this->allowedToPost = false;
		$this->discussionClosed = false;
		$this->emoticons = ccommentHelperUtils::getEmoticons($this->config);
		if ((ccommentHelperSecurity::canPost($this->config))) {
			$this->allowedToPost = true;
		}

		if (in_array($this->plugin->getPageId(), $this->config->get('basic.disable_additional_comments'))) {
			$this->discussionClosed = true;
		}

		//Look for template files in component folders
		$this->addTemplatePath(JPATH_BASE . '/components/com_comment/templates/'.$commentTemplate);

		// Look for overrides in template folder (CComment template structure)
		$this->addTemplatePath(JPATH_THEMES .'/'. $appl->getTemplate() . '/html/com_comment/templates/'.$commentTemplate);

		return $this->loadTemplate();
	}

	public function readMore()
	{
		$appl = JFactory::getApplication();
		$config = $this->config;
		$commentTemplate = $config->get('template.template', 'default');
		$this->discussionClosed = false;
		$this->commentTranslation = $this->translateComments($this->count);

		if (in_array($this->plugin->getPageId(), $this->config->get('basic.disable_additional_comments'))) {
			$this->discussionClosed = true;
		}

		//Look for template files in component folders
		$this->addTemplatePath(JPATH_BASE . '/components/com_comment/templates/'.$commentTemplate);

		// Look for overrides in template folder (CComment template structure)
		$this->addTemplatePath(JPATH_THEMES .'/'. $appl->getTemplate() . '/html/com_comment/templates/'.$commentTemplate);

		return $this->loadTemplate();
	}

	/**
	 * Russian and Ukrainian have strange rules for
	 * plural so we try to figure out what translation we need to show
	 *
	 * @param $number - int - number of comments
	 * @return string - proper plural translation
	 */
	public function translateComments($number)
	{
		$document = JFactory::getDocument();
		$currentLanguage = $document->language;
		if (($currentLanguage == 'ru-ru') || ($currentLanguage == 'uk-ua')) {
			$count_id = (int)fmod($number, 100);
			if ($count_id >= 11 && $count_id <= 19) {
				$comments = JText::_('COM_COMMENT_COMMENTS_0');
			} else {
				switch ((int)fmod($count_id, 10)) {
					case 1:
						$comments = JText::_('COM_COMMENT_COMMENTS_1');
						break;
					case 2:
						$comments = JText::_('COM_COMMENT_COMMENTS_2_4');
						break;
					case 3:
						$comments = JText::_('COM_COMMENT_COMMENTS_2_4');
						break;
					case 4:
						$comments = JText::_('COM_COMMENT_COMMENTS_2_4');
						break;
					default:
						$comments = JText::_('COM_COMMENT_COMMENTS_0');
				}
			}
		} else {
			if ($number < 1) {
				$comments = JText::_('COM_COMMENT_COMMENTS_0');
			} elseif ($number == 1) {
				$comments = JText::_('COM_COMMENT_COMMENTS_1');
			} elseif ($number >= 2 && $number <= 4) {
				$comments = JText::_('COM_COMMENT_COMMENTS_2_4');
			} else {
				$comments = JText::_('COM_COMMENT_COMMENTS_MORE');
			}
		}
		return $comments;
	}

}