<?php
/**
 * Element: Load Language
 * Loads the English language file as fallback
 *
 * @package         NoNumber Framework
 * @version         13.11.21
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2013 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

class JFormFieldNN_LoadLanguage extends JFormField
{
	public $type = 'LoadLanguage';
	private $params = null;

	protected function getLabel()
	{
		return '';
	}

	protected function getInput()
	{
		$this->params = $this->element->attributes();

		$extension = $this->get('extension');
		$admin = $this->get('admin', 1);

		self::loadLanguage($extension, $admin);

		return '';
	}

	function loadLanguage($extension, $admin = 1)
	{
		if ($extension)
		{
			$path = $admin ? JPATH_ADMINISTRATOR : JPATH_SITE;
			$lang = JFactory::getLanguage();
			if ($lang->getTag() != 'en-GB')
			{
				// Loads English language file as fallback (for undefined stuff in other language file)
				$lang->load($extension, $path, 'en-GB');
			}
			$lang->load($extension, $path, null, 1);
		}
	}

	private function get($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}
