<?php
/**
 * @version     $Id$
 * @package     JSN.ImageShow
 * @subpackage  JSN.ThemeCarousel
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */
defined('_JEXEC') or die('Restricted access');
JTable::addIncludePath(JPATH_ROOT.DS.'plugins'.DS.'jsnimageshow'.DS.'themeflow'.DS.'tables');
class ThemeFlow
{
	var $_pluginName	= 'themeflow';
	var $_pluginType	= 'jsnimageshow';
	var $_table			= 'theme_flow';
	
	function &getInstance()
	{
		static $themeFlow;
		if ($themeFlow == null) {
			$themeFlow = new ThemeFlow();
		}
		return $themeFlow;
	}
	
	function ThemeFlow()
	{
		$pathModelShowcaseTheme = JPATH_PLUGINS.DS.$this->_pluginType.DS.$this->_pluginName.DS.'models';
		$pathTableShowcaseTheme = JPATH_PLUGINS.DS.$this->_pluginType.DS.$this->_pluginName.DS.'tables';
		JModelLegacy::addIncludePath($pathModelShowcaseTheme);
		JTable::addIncludePath($pathTableShowcaseTheme);
	}
	
	function getTable($themeID = 0)
	{
		$showcaseThemeTable = JTable::getInstance($this->_pluginName, 'Table');
		
		if (!$showcaseThemeTable->load((int) $themeID))
		{
			$showcaseThemeTable = JTable::getInstance($this->_pluginName, 'Table');// need to load default value when theme record has been deleted
			$showcaseThemeTable->load(0);
		}
		return $showcaseThemeTable;
	}
	
	function _prepareSaveData($data)
	{
		if (!empty($data))
		{
			return $data;
		}
		return false;
	}
	
	function _prepareDataJSON($themeID, $URL)
	{
		return true;
	}
}