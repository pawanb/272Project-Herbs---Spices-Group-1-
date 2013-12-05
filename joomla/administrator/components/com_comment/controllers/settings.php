<?php
/***************************************************************
*  Copyright notice
*
*  Copyright 2009 Daniel Dimitrov. (http://compojoom.com)
*  All rights reserved
*
*  This script is part of the Compojoom Comment project. The Compojoom Comment project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
defined('_JEXEC') or die();

/**
 * Plugins Component Controller
 *
 * @package		Joomla
 * @subpackage	Plugins
 * @since 1.5
 */
class ccommentControllerSettings extends ccommentController {
	public function __construct() {
		parent::__construct();
		$this->registerTask( 'apply', 'save' );
	}

	public function choose() {
		$view = $this->getView('Settings', 'html', 'ccommentView');
		// Get/Create the model
		if ($model = $this->getModel('settings'))
		{
			// Push the model into the view (as default)
			$view->setModel($model, true);
		}

		$view->choose();
	}

	public function edit() {
		$input = JFactory::getApplication()->input;
		$component = $input->getCmd('component');
		$view = $this->getView('Settings', 'html', 'ccommentView');
		$model = $this->getModel('Settings', 'ccommentModel');
		$data = '';
		$view->setModel($model, true);
		$setting = $model->getItem($component);

		if($setting) {
			$data = new JRegistry($setting->params);
		} else {
			$setting = new stdClass();
			$setting->id = 0;
			$setting->component = $component;
			$setting->note = '';
		}

		$path = JPATH_COMPONENT_ADMINISTRATOR .'/models/forms/settings.xml';
		$form = new JForm('ccommentSettings', array('control' => 'jform'));

		$form->loadFile($path);
		$form->bind($data);

		$view->form = $form;
		$view->item = $setting;
		$view->setLayout('edit');
		$view->display();
	}

    /*
     * function to save the configuration
     */
	public function save() {
		JSession::checkToken() or jexit('Invalid Token');
		$appl = JFactory::getApplication();
		$input = JFactory::getApplication()->input;
		$data = $input->post->get('jform', array(), 'array');

		$id = $input->getInt('id');

		$registry = new JRegistry($data);;

		$saveData = array(
			'id' => $id,
			'note' => $input->getString('note'),
			'component' => $input->getString('component'),
			'params' => $registry->toString()
		);

		JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_comment/tables');
		$row = JTable::getInstance('Setting', 'CommentTable');
		$row->load($id);

		if (!$row->bind($saveData)) {
			throw new Exception('Error binding data');
		}

		if (!$row->store()) {
			throw new Exception('Error binding saving data');
		}

		switch ($input->getCmd('task')) {
			case 'apply' :
				$link = JRoute::_('index.php?option=com_comment&task=settings.edit&component='.$row->component, false);
				break;
			case 'save':
				$link = JRoute::_('index.php?option=com_comment&view=settings', false);
				break;
		}

		$appl->redirect($link, JText::_('COM_COMMENT_SETTING_SAVED'));
	}

	public function remove() {
		JSession::checkToken() or jexit('Invalid Token');
		$mainframe = JFactory::getApplication();
		$cid = JRequest::getVar('cid', array(), '', 'array');
		$database = JFactory::getDBO();
		if (count($cid)) {
			$cids = implode(',', $cid);
			$query = 'DELETE FROM ' . $database->qn('#__comment_setting')
				. ' WHERE id IN (' . $cids . ')';
			$database->setQuery($query);

			if(!$database->query()) {
				echo "<script> alert('" . $database->getErrorMsg() . "');
		    window.history.go(-1); </script>";
			}
		}

		$mainframe->redirect('index.php?option=com_comment&view=settings');
	}

	public function cancel() {
		$mainframe = JFactory::getApplication();
		$mainframe->redirect('index.php?option=com_comment&view=settings');
	}
}