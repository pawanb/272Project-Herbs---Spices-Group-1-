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
jimport( 'joomla.plugin.plugin' );
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_imageshow'.DS.'classes'.DS.'jsn_is_factory.php');
class plgJSNImageshowThemeFlow extends JPlugin
{
	var $_showcaseThemeName = 'themeflow';
	var $_showcaseThemeType = 'jsnimageshow';
	var $_pathAssets		= 'plugins/jsnimageshow/themeflow/assets/';
	var $_tableName			= 'theme_flow';
	
	function onLoadJSNShowcaseTheme($name, $themeID = 0)
	{
		if ($name != $this->_showcaseThemeName) {
			return false;
		}
		
		JPlugin::loadLanguage('plg_' . $this->_showcaseThemeType . '_' . $this->_showcaseThemeName);
		
		ob_start();
		
		JHTML::stylesheet($this->_pathAssets.'css/'.'style.css');
		JHTML::stylesheet($this->_pathAssets.'css/'.'jsn_is_flowtheme.css');
		JHTML::script($this->_pathAssets.'js/'.'jsn_is_themeflow_setting.js');
		
		include(dirname(__FILE__).DS.'helper'.DS.'helper.php');
		include(dirname(__FILE__).DS.'views'.DS.'default.php');
		
		return ob_get_clean();
	}

	function onDisplayJSNShowcaseTheme($args)
	{
		if ($args->theme_name != $this->_showcaseThemeName) {
			return false;
		}
		
		JPlugin::loadLanguage('plg_'.$this->_showcaseThemeType.'_'.$this->_showcaseThemeName);
		$basePath			= JPATH_PLUGINS.DS.$this->_showcaseThemeType.DS.$this->_showcaseThemeName;
		$objThemeDisplay	= JSNISFactory::getObj('classes.jsn_is_flowdisplay', null, null, $basePath);
		$result				= $objThemeDisplay->display($args);
		return $result;
	}
	
	function onExtensionBeforeUninstall($eid)
	{
		$query	= 'DROP TABLE IF EXISTS `#__imageshow_' . $this->_tableName . '`';
		$db		= JFactory::getDbo();
		$db->setQuery($query);
		$db->query();
	}

	public function getLanguageJSNPlugin()
	{
		$language = array();
		$language['admin']['files'] = array('plg_' . $this->_showcaseThemeType . '_' . $this->_showcaseThemeName . '.ini');
		$language['admin']['path']	= array(dirname(__FILE__) . DS . 'languages');
		
		return $language;
	}
	
	function listThemeflowTable()
	{
		return array('#__imageshow_theme_flow');
	}	
}