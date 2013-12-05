<?php
/**
 * @version    $Id$
 * @package    JSN_Framework
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Manually import class file of JSN Framework.
 *
 * Besides auto-loader, JSN Framework provides <b>jsnimport</b> function
 * for manually load class declaration file using dot syntax as following:
 *
 * <dl>
 * <dt>jsnimport('joomlashine.config.helper');</dt>
 * <dd>will load the following file: <q>libraries/joomlashine/config/helper.php</q></dd>
 * <dt>jsnimport('somevendor.somelib.someclass');</dt>
 * <dd>will load the following file:<q>libraries/somevendor/somelib/someclass.php</q></dd>
 * </dl>
 *
 * This function also supports loading class file from component directory
 * instead of framework directory. For example, in the administration section
 * of your component, create following directory structure:
 *
 * <pre>- JoomlaRoot/administrator/components/com_YourComponent
 *     - libraries
 *         - joomlashine
 *             + test
 * </pre>
 *
 * Then create a file named <b>helper.php</b> under the <b>test</b> directory.
 * Now, in your component, simply use following function call to load that file:
 *
 * <code>jsnimport('joomlashine.test.helper');</code>
 *
 * If you follow the class naming rule of JSN Framework, e.g. the class declared
 * in the above file is named <b>JSNTestHelper</b>, then your class will
 * autoload-able anywhere it is used without the need of executing the above
 * code first.
 *
 * @param   string  $path       A dot syntax path.
 * @param   string  $className  Class name.
 *
 * @return  boolean
 */
function jsnimport($path, $className = '')
{
	static $imported;

	// Only import the library if not already attempted
	if ( ! isset($imported[$path]))
	{
		// Check if class already declared
		if ( ! empty($className) AND class_exists($className, false))
		{
			return ($imported[$path] = true);
		}

		// Initialize variables
		$appl = is_object($appl = JFactory::getApplication()->input) ? $appl->getCmd('option') : '';
		$file = str_replace('.', '/', $path) . '.php';;
		$path = JPATH_ROOT . '/administrator/components/' . $appl . '/libraries';

		// Prefer to look for class file from extension directory first
		if ($appl)
		{
			$filePath = is_file("{$path}/{ $file}") ? "{$path}/{ $file}" : null;
		}

		// Then look for class file from JSN Framework directory
		if ( ! isset($filePath))
		{
			$filePath = is_file(JSN_PATH_LIBRARIES . "/{$file}") ? JSN_PATH_LIBRARIES . "/{$file}" : null;
		}

		// If the file exists attempt to include it
		if (isset($filePath))
		{
			$success = (bool) require_once $filePath;
		}

		// Add the import key to the memory cache container.
		$imported[$path] = isset($success) ? $success : false;
	}

	return $imported[$path];
}

/**
 * Autoload class file of JSN Framework.
 *
 * PHP libraries, inside <b>libraries/joomlashine</b> directory, must accept
 * following naming rule for autoload-able:
 *
 * <blockquote>
 * File path: libraries/joomlashine/itemlist/helper.php
 * <br />
 * <b>Right class name: JSNItemlistHelper</b>
 * <br />
 * <i>Wrong class name: JSNItemListHelper</i>
 * </blockquote>
 *
 * For the second class name, file path must be:
 *
 * <blockquote>
 * Class name: JSNItemListHelper
 * <br />
 * <b>File path: libraries/joomlashine/item/list/helper.php</b>
 * </blockquote>
 *
 * This function also supports overwritting core class file. For example, to
 * overwrite the core class, <b>JSNConfigHelper</b>, create following
 * directory structure:
 *
 * <pre>- JoomlaRoot/administrator/components/com_YourComponent
 *     - libraries
 *         - joomlashine
 *             + config
 * </pre>
 *
 * Then create a file named <b>helper.php</b> under the <b>config</b> directory
 * and declare your own <b>JSNConfigHelper</b> class in that file.
 *
 * @param   string  $className  Name of class needs to be loaded.
 *
 * @return  boolean
 */
function jsnloader($className)
{
	// Only autoload class name prefixed with JSN
	if (substr($className, 0, 3) == 'JSN')
	{
		// Split the class name into parts separated by camelCase
		$parts = preg_split('/(?<=[a-z0-9])(?=[A-Z])/x', substr($className, 3));

		// If class name has single word, e.g. JSNVersion, duplicate it for valid file path, e.g. version/version.php
		$parts = count($parts) == 1 ? array($parts[0], $parts[0]) : $parts;

		// Convert to class name to dot-based path
		$parts = implode('.', array_map('strtolower', $parts));

		return jsnimport('joomlashine.' . $parts, $className);
	}
}

// Register jsnloader for autoloading JoomlaShine's PHP libraries
spl_autoload_register('jsnloader');
