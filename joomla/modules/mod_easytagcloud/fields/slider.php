<?php
/*
 * Slider
 *
 * @package		Easytagcloud
 * @version		2.3
 * @author		Kee 
 * @copyright	Copyright (c) 2012 www.joomlatonight.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * @orginal jave script from http://dhtmlx.com
 */

defined('_JEXEC') or die ('Restricted access');

jimport('joomla.form.formfield');
/*

*/		

class JFormFieldSlider extends JFormField
{
	protected $type = 'Slider';
	
	function getInput()
	{
		$this->_includeAssets();
		$uri = $this->_getRootAssetsUri();
		$node = $this->element;
		$id = str_replace(array('[', ']'), array('_', ''), $this->name);
			return '<input type="text" name="'.$this->name.'" id="'.$id.'" value="'.$this->value.'"/>
		<script> 
		window.dhx_globalImgPath="'.$uri.'imgs/";
		var '.$id.'= new dhtmlxSlider(null, 250, "arrowgreen", null, '.$node['min'].', '.$node['max'].', '.$this->value.', '.$node['step'].');'
		.$id.'.linkTo(\''.$id.'\');'
		.$id.'.init();
		</script>';  
	}
	
	function _includeAssets()
	{
		static $loaded;
		
		if ($loaded)
			return ;
			
		$uri = $this->_getRootAssetsUri();	
			
		$document = JFactory::getDocument();	
		$document->addScript($uri . 'dhtmlxslider.js');		
		$document->addScript($uri . 'dhtmlxcommon.js');		
		$document->addScript($uri . 'ext/dhtmlxslider_start.js');	
		$document->addStyleSheet($uri . 'dhtmlxslider.css', 'text/css', null, array());				
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
			
		$uri = JURI::root(true) . str_replace(DIRECTORY_SEPARATOR, '/', $filePath) . '/slider/';
		
		return $uri;
	}
}
?>