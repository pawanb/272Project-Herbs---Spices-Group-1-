<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 11.03.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
 
defined('_JEXEC') or die('Restricted access');

class ccommentHelperTable {

	private static $instances = null;

	public static function getTableList()
	{
		$database = JFactory::getDBO();
		$database->setQuery( 'SHOW TABLES' );
		return $database->loadColumn();
	}

	public static function existsTable($name) {
		if(!isset(self::$instances[$name])) {
			$database = JFactory::getDBO();
			$quotedname = $database->q($database->replacePrefix($name));
			$database->setQuery('SHOW TABLES LIKE '.($quotedname));
			self::$instances[$name] = $database->loadResult() ? true : false;
		}

		return self::$instances[$name];
	}

	public static function getTableColumns( $tablename, $key='' ) {
		$database = JFactory::getDBO();

		$database->setQuery("SHOW COLUMNS FROM ".$database->replacePrefix($tablename));
		return ( $database->loadObjectList($key) );
	}

	function TableFieldCheck( $fieldname, &$tablecols ) {

		if (!$tablecols) return false;
		$found = false;

		foreach( $tablecols as $col ) {
			if ($col->Field == $fieldname) {
				$found = true;
				break;
			}
		}

		return( $found );
	}
}