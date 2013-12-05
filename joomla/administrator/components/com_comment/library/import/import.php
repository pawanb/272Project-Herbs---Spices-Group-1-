<?php
/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date       : 11.03.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

JLoader::register('ccommentImporter', JPATH_COMPONENT_ADMINISTRATOR . '/library/import/importer.php');

/**
 * Class ccommentImport
 *
 * @since  5.0
 */
class ccommentImport
{
	/**
	 * The constructor
	 *
	 * @param   string  $component  - the component we import from
	 */
	public function __construct($component)
	{
		$name = 'ccommentImport' . ucfirst($component);
		JLoader::register($name, JPATH_COMPONENT_ADMINISTRATOR . '/library/import/components/' . $component . '.php');

		try
		{
			$this->importer = new $name;
		}
		catch (Exception $e)
		{
			$appl = JFactory::getApplication();
			$appl->redirect('index.php?option=com_comment&view=import', $e->getMessage() . JText::sprintf('COM_COMMENT_IMPORT_FOR_COMPONENT_NOT_SUPPORTED', $component), 'error');
		}

		return $this;
	}

	/**
	 * Check if the component exist
	 *
	 * @return mixed
	 */
	public function exist()
	{
		return $this->importer->exist();
	}

	/**
	 * Import the comments
	 *
	 * @return mixed
	 */
	public function import()
	{
		return $this->importer->import();
	}
}
