<?php
/*
 * Update Tags Element
 *
 * @package		EasyTagcloud
 * @version		2.4
 * @author		Kee Huang
 * @copyright	Copyright (c) 2013 www.joomlatonight.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 */

defined('_JEXEC') or die ('Restricted access');

jimport('joomla.form.formfield');


class JFormFieldStylechanger extends JFormField
{
	protected $type = 'Stylechanger';
	
	function getInput()
	{   
		$this->_includeAssets();  	
		return false;      
	}
	
	function _includeAssets()
	{
		static $loaded;
		
		if ($loaded)
			return ;
			
		$uri = $this->_getRootAssetsUri();
			
		$document = JFactory::getDocument();
		$document->addScript($uri . 'stylechanger.js');		
		$loaded = true;
	}
	
	function _getRootAssetsUri()
	{
		static $uri;
		
		if (!is_null($uri))
			return $uri;
		
		$filePath = str_replace(DIRECTORY_SEPARATOR == '\\' ? '/' : '\\', DIRECTORY_SEPARATOR, dirname(__FILE__));
		if (strlen(JPATH_ROOT) > 1)
			$filePath = str_replace(JPATH_ROOT, '', $filePath);
			
		$uri = JURI::root(true) . str_replace(DIRECTORY_SEPARATOR, '/', $filePath) . '/stylechanger/';
		
		return $uri;
	}
}
?>