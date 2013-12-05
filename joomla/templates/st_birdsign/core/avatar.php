<?php
/**
 * @version		$Id: coolfeed.php 100 2012-04-14 17:42:51Z trung3388@gmail.com $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 * @package		Avatar Dream Framework Template
 * @facebook 	http://www.facebook.com/pages/JoomAvatar/120705031368683
 * @twitter	    https://twitter.com/#!/JoomAvatar
 * @support 	http://joomavatar.com/forum/
 */

// No direct access
defined('_JEXEC') or die;
jimport('joomla.filesystem.file');
class Avatar extends JObject 
{
	protected static $_copyright = '2013 - Powered by <a href="http://www.beautiful-templates.com">Beautiful-Templates.com</a>. All Rights Reserved.';
	protected static $_version = '1.0.0';
	protected static $_edition = 'pro';
	protected static $_templateFullName = 'Avatar Framework';
	protected static $_instances;
	public static $_paths = null;
	public static $_templateName = 'avatar_simple';
	
	
	/**
	 * return copyright
	 * @param display = 0 - style display = none
	 */
	public static function getCopyright($display = 1) 
	{
		if ($display) $style = '';
		if (!$display) $style = 'style="display: none;"';
		return '<div id="avatar-template-copyright" '.$style.'>'.self::$_copyright.'</div>';
	}
	
	/**
	 * return Framework's version
	 */
	public static function getVersion() {
		return self::$_version;
	}
	
	/**
	 * return Framework's edition
	 */
	public static function getEdition() {
		return self::$_edition;
	}
	
	/**
	 * 
	 * template framework information
	 */
	 
	public static function getTemplateInfo() {
		return  self::$_templateFullName . ' ' . self::$_version . ' ' . self::$_edition;
	} 
	
	
	public static function getInstance( $class = '' )
	{
		if (self::$_instances[$class]) {
			return self::$_instances[$class];
		}
		return self::$_instance = new Avatar();
	} 
	
	public static function loadFrameWork(){
		self::loadPath();
	}
	
	public static function getTemplate($Jtemplate = null) 
	{
		if (empty(self::$_instances['template'])) 
		{
			if (!class_exists('AvatarTemplate'))
			{
				$path = dirname(__FILE__) . '/classes/template.php';
				if (file_exists($path)) {
					require_once $path;
				} else {
					JError::raiseError(500, JText::_('CORE_AVATAR_CAN_NOT_LOAD'));
				}
			}
			
			self::$_instances['template'] = new AvatarTemplate($Jtemplate);
		}
		
		return self::$_instances['template'];
	}
	
	public static function loadPath()
	{
		self::$_paths['template'] 	= dirname(dirname(__FILE__));
		self::$_paths['core'] 		= self::$_paths['template'].DIRECTORY_SEPARATOR.'core';
		self::$_paths['classes'] 	= self::$_paths['core'].DIRECTORY_SEPARATOR.'classes';
		self::$_paths['helpers'] 	= self::$_paths['core'].DIRECTORY_SEPARATOR.'helpres'; 
	}
	
	public static function import($agr = '', $ext = 'php')
	{
		if ($agr != '')	
		{
			$file = self::$_paths['template'].DIRECTORY_SEPARATOR.str_replace('.', DIRECTORY_SEPARATOR, $agr).'.'.$ext;
			if (JFile::exists($file)) {
				require_once $file;
				return true;
			}
		}
		return false;
	}
	
	public static function isHandleDevice() {
		self::import('core.helpers.device');
		return AvatarDevice::detectDevice();
	} 
	
	/**
	 * get default overriden layout in core framework
	 */
	public static function getOverrideLayout($searchLayout = '')
	{
		if ($searchLayout != '') 
		{
			$site 		= JFactory::getApplication('client');
			$template 	= $site->getTemplate(true);
			$showcase 	= $template->params->get('template_showcase');
			$layoutPath = str_replace(self::$_paths['template'].DIRECTORY_SEPARATOR.'html', '', $searchLayout);
			$layoutFile = false;
			
			// check in core/html
			if (JFile::exists(self::$_paths['template'].DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.$layoutPath)) {
				$layoutFile = self::$_paths['template'].DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.$layoutPath;
			}
			
			// check in showcases
			if (JFile::exists(self::$_paths['template'].DIRECTORY_SEPARATOR.'showcases'.DIRECTORY_SEPARATOR.$showcase.DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.$layoutPath)) {
				$layoutFile = self::$_paths['template'].DIRECTORY_SEPARATOR.'showcases'.DIRECTORY_SEPARATOR.$showcase.DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.$layoutPath;
			}
			
			return $layoutFile;
		}
		
		return false;
	}
}
