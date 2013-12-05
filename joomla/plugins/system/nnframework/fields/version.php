<?php
/**
 * Element: Version
 * Displays the version check
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

class JFormFieldNN_Version extends JFormField
{
	public $type = 'Version';
	private $params = null;

	protected function getLabel()
	{
		return '';
	}

	protected function getInput()
	{
		$this->params = $this->element->attributes();

		$extension = $this->get('extension');
		$xml = $this->get('xml');
		if (!strlen($extension) || !strlen($xml))
		{
			return '';
		}

		$authorise = JFactory::getUser()->authorise('core.manage', 'com_installer');
		if (!$authorise)
		{
			return '';
		}

		require_once JPATH_PLUGINS . '/system/nnframework/helpers/versions.php';
		return '</div><div class="hide">' . NNVersions::getInstance()->getMessage($extension, $xml);
	}

	private function get($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}
