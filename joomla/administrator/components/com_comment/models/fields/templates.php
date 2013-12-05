<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 17.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

class JFormFieldTemplates extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 */
	protected $type = 'templates';


	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 */
	protected function getOptions()
	{

		jimport('joomla.filesystem.folder');
		$templates = array();
		$templateTemplates = array();
		$defaultTemplates = JFolder::folders(JPATH_COMPONENT_SITE . '/templates');

		$joomlaTemplate = ccommentHelperTemplate::getFrontendTemplate();

		if($joomlaTemplate) {
			$path = JPATH_SITE . '/templates/'.$joomlaTemplate . '/html/com_comment/templates';
			if(file_exists($path)) {
				$templateTemplates = JFolder::folders($path);
			}
		}

		$tmp = array_merge($defaultTemplates, $templateTemplates);
		foreach($tmp as $value) {
			$templates[$value] = $value;
		}

		return $templates;
	}
}
