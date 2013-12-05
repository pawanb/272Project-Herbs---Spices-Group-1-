<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 17.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

class JFormFieldEmoticons extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 */
	protected $type = 'emoticons';

	public function __construct() {
		parent::__construct();

		JHtml::_('behavior.framework', true);
		JHtml::script('media/com_comment/backend/js/emoticons.js');
		JHtml::stylesheet('media/com_comment/backend/css/emoticons.css');

		$document = JFactory::getDocument();

		$script = "window.addEvent('domready', function(){new emoticons('jform_layout_emoticon_pack')});";
		$document->addScriptDeclaration($script);
	}

	protected function getInput()
	{
		$html = array();
		$attr = '';

		// Initialize some field attributes.
		$attr .= $this->element['class'] ? ' class="' . (string)$this->element['class'] . '"' : '';

		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ((string)$this->element['readonly'] == 'true' || (string)$this->element['disabled'] == 'true') {
			$attr .= ' disabled="disabled"';
		}

		$attr .= $this->element['size'] ? ' size="' . (int)$this->element['size'] . '"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';

		// Initialize JavaScript field attributes.
		$attr .= $this->element['onchange'] ? ' onchange="' . (string)$this->element['onchange'] . '"' : '';


		$options = $this->getEmoticonPacks();

		$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		foreach($options as $option) {
			$html[] = $this->outputEmoticons($option);
		}
		return implode($html);
	}

	protected function outputEmoticons($pack)
	{
		$html = array();
		$path = JPATH_SITE . '/components/com_comment/assets/emoticons/' . $pack . '/config.php';
		$override = JPATH_SITE . '/templates/' . ccommentHelperTemplate::getFrontendTemplate() . '/html/com_comment/emoticons/' . $pack . '/config.php';
		if(is_file($override)) {
			require_once($override);
		} else if(is_file($path)) {
			require_once($path);
		} else {
			return '';
		}

		if (isset($ccommentEmoticons)) {
			$html[] = '<div id="emoticons-'.$pack.'" class="emoticons">';
			foreach ($ccommentEmoticons as $icon) {
				$src = JUri::root() . 'media/com_comment/emoticons/' . $pack . '/images/' . $icon;
				if (is_file($override)) {
					$src = JUri::root() . 'templates/' . ccommentHelperTemplate::getFrontendTemplate() . '/html/com_comment/emoticons/' . $pack . '/images/' . $icon;
				}
				$html[] = '<img src="'. $src . '" title="' . $icon . '" />';
			}
			$html[] = '</div>';
		}

		return implode('',$html);
	}

	protected function getEmoticonPacks()
	{
		jimport('joomla.filesystem.folder');
		$options = array();
		$path = JPATH_SITE . '/components/com_comment/assets/emoticons';
		$overrides = JPATH_SITE . '/templates/'.ccommentHelperTemplate::getFrontendTemplate().'/html/com_comment/emoticons';

		$packs = JFolder::folders($path);
		foreach ($packs as $pack) {
			$options[$pack] = $pack;
		}

		if(file_exists($overrides)) {
			$packs = JFolder::folders($overrides);
			foreach ($packs as $pack) {
				$options[$pack] = $pack;
			}
		}

		return $options;
	}
}
