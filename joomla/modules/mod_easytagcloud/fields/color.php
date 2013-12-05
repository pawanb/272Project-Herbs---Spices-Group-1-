<?php
/*
 * Color Picker Element
 *
 * @package		easytagcloud
 * @version		1.0
 * @author		Kee 
 * @copyright	Copyright (c) 2012 www.joomlatonight.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * @javascript script from www.jscolor.com v1.4.0
 */

defined('_JEXEC') or die ('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldColor extends JFormField
{
	protected $type = 'Color';
	
	function getInput()
	{
		$this->_includeAssets();  
		 
		$id = str_replace(array('[', ']'), array('_', ''), $this->name);
		return '<input class="color {required:false,hash:true}" type="text" name="'.$this->name.'" id="'.$id.'" value="'.$this->value.'"/><span style="margin: 6px 5px 5px 0; display: block; float: left;">[<a href="javascript:void(0);" onclick="$(\''.$id.'\').value = \'\'; return false;">Clear</a>]</span>';      
	}
	
	function _includeAssets()
	{
		static $loaded;
		
		if ($loaded)
			return ;
			
		$uri = $this->_getRootAssetsUri();
			
		$document = JFactory::getDocument();
		$document->addScript($uri . 'jscolor.js');		
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
			
		$uri = JURI::root(true) . str_replace(DIRECTORY_SEPARATOR, '/', $filePath) . '/jscolor/';
		
		return $uri;
	}
}
?>