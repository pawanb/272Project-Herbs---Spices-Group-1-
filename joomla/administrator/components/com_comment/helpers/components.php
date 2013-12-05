<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 17.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
 
defined('_JEXEC') or die('Restricted access');

class ccommentHelperComponents {

	protected static $components;

	public static function isInstalled($component) {
		$components = self::getComponents();

		if(isset($components[$component])) {
			return $components[$component];
		}

		return false;
	}

	/**
	 * Checks if components that we support are installed
	 * @return array
	 */
	protected static function getComponents() {

		if(!isset(self::$components)) {
			jimport('joomla.filesystem.folder');

			$components = array(
				'com_comprofiler' => false,
				'com_community' => false,
				'com_k2' => false,
				'com_kunena' => false);

			foreach($components as $key => $value) {
				$folderPath = JPATH_SITE . '/' .'components/'.$key;
				$components[$key] = JFolder::exists($folderPath);
			}

			self::$components = $components;
		}

		return self::$components;
	}

	/**
	 * Get a list with supported comments
	 */
	public static function getComponentList() {
		jimport('joomla.filesystem.folder');
		$list = JFolder::folders(JPATH_COMPONENT_ADMINISTRATOR.'/plugins/');
		$options = array();

		foreach($list as $value) {
			$options[$value] = $value;
		}
		return $options;
	}

	public static function getComponentVersion($component) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('manifest_cache')->from('#__extensions')
			->where('element ='.$db->q($component))
			->where('type='.$db->q('component'));
		$db->setQuery($query);

		$manifest = $db->loadObject();
		$registry = new JRegistry();
		if($manifest) {
			$registry->loadString($manifest->manifest_cache);
			return $registry;
		}

		return $registry;
	}
}