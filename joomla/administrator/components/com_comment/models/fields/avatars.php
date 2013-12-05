<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 17.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

class JFormFieldAvatars extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 */
	protected $type = 'avatars';


	protected function getInput()
	{

		$attr = '';

		// Initialize some field attributes.
		$attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';

		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ((string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true')
		{
			$attr .= ' disabled="disabled"';
		}

		$attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';

		// Initialize JavaScript field attributes.
		$attr .= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

		$options = $this->getOptions();

		return JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);

	}
	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 */
	protected function getOptions()
	{
		$options = array('0' => JText::_('COM_COMMENT_NONE'));

		$components = explode(',', $this->element['components']);
		foreach($components as $component) {
			$component = trim($component);
			if(ccommentHelperComponents::isInstalled($component)) {
				$options[$component] = JText::_($component);
			}
		}
		return $options;
	}
}
