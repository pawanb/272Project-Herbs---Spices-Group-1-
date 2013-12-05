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

jimport('joomla.plugin.plugin');

include_once (JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_imageshow' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'jsn_is_factory.php');

class plgJSNImageshowThemeStrip extends JPlugin
{
	var $_showcaseThemeName = 'themestrip';
	var $_showcaseThemeType = 'jsnimageshow';
	var $_pathAssets 		= 'plugins/jsnimageshow/themestrip/assets/';
	var $_tableName			= 'theme_strip';

	function onLoadJSNShowcaseTheme($name, $themeID = 0)
	{
		if ($name != $this->_showcaseThemeName)
		{
			return false;
		}

		JPlugin::loadLanguage('plg_' . $this->_showcaseThemeType . '_' . $this->_showcaseThemeName);
		ob_start();

		JHTML::stylesheet($this->_pathAssets . 'css/admin/' . 'style.css');
		JHTML::stylesheet($this->_pathAssets . 'css/admin/elastislide/elastislide.css');
		JHTML::script($this->_pathAssets . 'js/admin/jsn_is_themestrip.js');
		
		include_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'helper.php');
		include_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'default.php');

		return ob_get_clean();
	}

	function onExtensionBeforeUninstall($eid)
	{
		$query 	= 'DROP TABLE IF EXISTS `#__imageshow_' . $this->_tableName . '`';
		$db 	= JFactory::getDbo();
		$db->setQuery($query);
		$db->query();
	}

	function getLanguageJSNPlugin()
	{
		$language = array();
		$language['admin']['files'] = array('plg_' . $this->_showcaseThemeType . '_' . $this->_showcaseThemeName . '.ini');
		$language['admin']['path'] 	= array(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'languages');

		return $language;
	}

	function onDisplayJSNShowcaseTheme($args)
	{
		if ($args->theme_name != $this->_showcaseThemeName) 
		{
			return false;
		}

		JHTML::stylesheet($this->_pathAssets . 'css/style.css');
		JPlugin::loadLanguage('plg_' . $this->_showcaseThemeType . '_' . $this->_showcaseThemeName);
		$basePath 		 = JPATH_PLUGINS . DIRECTORY_SEPARATOR . $this->_showcaseThemeType . DIRECTORY_SEPARATOR . $this->_showcaseThemeName;
		$objThemeDisplay = JSNISFactory::getObj('classes.jsn_is_stripdisplay', null ,null, $basePath);
		$result			 = $objThemeDisplay->display($args);
		return $result;
	}

	function listThemestripTable()
	{
		return array('#__imageshow_theme_strip');
	}
}