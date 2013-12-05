<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 15.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
 
defined('_JEXEC') or die('Restricted access');

class ccommentControllerTemplate extends ccommentController {

	public function getParams(){
		$input = JFactory::getApplication()->input;
		$template = $input->getString('template', 'default');
		$component = $input->getString('component');
		try{
			$data = ccommentConfig::getConfig($component);
		} catch (Exception $e) {
			// no config yet
			$data = array();
		}

		$path = JPATH_COMPONENT_SITE .'/templates/'.$template.'/settings.xml';
		$form = new JForm('ccommentTemplate', array('control' => 'jform'));

		$form->loadFile($path);

		// let us see if the joomla template has a template for ccomment
		$joomlaTemplate = ccommentHelperTemplate::getFrontendTemplate();
		$path = JPATH_SITE . '/templates/'.$joomlaTemplate.'/html/com_comment/templates/'.$template.'/settings.xml';
		if(file_exists($path)) {
			$form->loadFile($path);
		}

		$form->bind($data);
		$view = $this->getView('template', 'html');
		$view->form = $form;
		$view->display();
	}
}