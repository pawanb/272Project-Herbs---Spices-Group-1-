<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       03.09.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

JLoader::register('ccommentImport', JPATH_COMPONENT_ADMINISTRATOR . '/library/import/import.php');

/**
 * Class ccommentControllerImport
 *
 * @since  5.0
 */
class CcommentControllerImport extends JControllerLegacy
{
	/**
	 * Function that loads the proper import script
	 *
	 * @return void
	 */
	public function from()
	{
		JSession::checkToken() or jexit('Invalid Token');
		$input = JFactory::getApplication()->input;
		$import = $input->getCmd('import');
		$table = $input->getCmd('table');
		$model = $this->getModel('Import', 'ccommentModel');
		$view = $this->getView('Import', 'html', 'ccommentView');
		$view->setModel($model, true);

		if ($import == 'general')
		{
			$this->setRedirect('index.php?option=com_comment&view=import&layout=general&table=' . $table);
		}
		else
		{
			$importer = new ccommentImport($import);
			$importer->import();
			$this->setRedirect('index.php?option=com_comment&view=comments&filter_search=' . $import);
		}
	}

	/**
	 * The import function
	 *
	 * @return void
	 */
	public function import()
	{
		JSession::checkToken() or jexit('Invalid Token');

		$table = JFactory::getApplication()->input->getCmd('table');
		$model = $this->getModel('Import');
		$msg = JText::_('COM_COMMENT_IMPORT_WAS_UNSUCCESSFUL');

		if ($model->import())
		{
			$msg = JText::_('COM_COMMENT_IMPORT_WAS_SUCCESSFUL');

		}

		$this->setRedirect('index.php?option=com_comment&view=comments&filter_search=' . $table, $msg);
	}
}
