<?php
/*
 * @package		EasyTagCloud
 * @copyright	Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
jimport('joomla.installer.installer');
class com_easytagcloudInstallerScript
{
	function install($parent) {
       $path = dirname(__FILE__).DS.'..'.DS.'modules'.DS.'mod_easytagcloud';
	   
	   //JFactory::getApplication()->enqueueMessage($path, 'message');
	   
       $installer = new JInstaller;
       $result = $installer->install($path);  	
	   $parent->getParent()->setRedirectURL('index.php?option=com_easytagcloud');	   	
	
	}
	function uninstall($parent) {
       $db = JFactory::getDBO();
       $query = "SELECT `extension_id` FROM `#__extensions` WHERE `type`='module' AND element ='mod_easytagcloud' ";
       $db->setQuery($query);
       $id = $db->loadResult();
       if ($id) {
           $installer = new JInstaller;
           $result = $installer->uninstall('module', $id);
       } 

	}
	
	function update($parent) {
	}
	
	function preflight($type, $parent) {
	}

	function postflight($type, $parent)  {
	}
}