<?php
/**
 * @version    $Id$
 * @package    JSN.ImageShow - Theme.Strip
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 *
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JTable::addIncludePath(JPATH_ROOT . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'jsnimageshow' . DIRECTORY_SEPARATOR . 'themestrip' . DIRECTORY_SEPARATOR . 'tables');
class ThemeStrip
{
	var $_pluginName 	= 'themestrip';
	var $_pluginType 	= 'jsnimageshow';
	var $_table 		= 'theme_strip';

	function &getInstance()
	{
		static $themeStrip;
		if ($themeStrip == null)
		{
			$themeStrip = new ThemeStrip();
		}
		return $themeStrip;
	}

	function ThemeStrip()
	{
		$pathModelShowcaseTheme = JPATH_PLUGINS . DIRECTORY_SEPARATOR . $this->_pluginType . DIRECTORY_SEPARATOR . $this->_pluginName . DIRECTORY_SEPARATOR . 'models';
		$pathTableShowcaseTheme = JPATH_PLUGINS . DIRECTORY_SEPARATOR . $this->_pluginType . DIRECTORY_SEPARATOR . $this->_pluginName . DIRECTORY_SEPARATOR . 'tables';
		JModelLegacy::addIncludePath($pathModelShowcaseTheme);
		JTable::addIncludePath($pathTableShowcaseTheme);
	}

	function _prepareSaveData($data)
	{
		if(!empty($data))
		{
			return $data;
		}
		return false;
	}

	function getTable($themeID = 0)
	{
		$showcaseThemeTable = JTable::getInstance($this->_pluginName, 'Table');

		if(!$showcaseThemeTable->load((int) $themeID))
		{
			$showcaseThemeTable =& JTable::getInstance($this->_pluginName, 'Table');// need to load default value when theme record has been deleted
			$showcaseThemeTable->load(0);
		}

		return $showcaseThemeTable;
	}

	function _prepareDataJSON($themeID, $URL)
	{
		return true;
	}
}