<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * EasyTagCloud View
 */
class EasyTagCloudViewEasyTagCloud extends JViewLegacy
{
	/**
	 * EasyTagCloud view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
	    /*
		$msg = $this->get('Msg');	
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		} 
		
		*/
		
		
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
        JHtml::stylesheet('com_easytagcloud/manager.css', array(), true, false, false);	
		JToolBarHelper::title(JText::_('COM_EASYTAGCLOUD_MANAGER_EASYTAGCLOUD'), 'easytagcloud');
		JToolBarHelper::preferences('com_easytagcloud');
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_EASYTAGCLOUD_ADMINISTRATION'));
        $document->addScript(JURI::root() . "administrator/components/com_easytagcloud/views/easytagcloud/convertor.js");
		
	}
}
