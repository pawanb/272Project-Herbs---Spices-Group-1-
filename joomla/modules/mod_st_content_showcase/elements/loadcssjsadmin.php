<?php

defined('_JEXEC') or die( 'Restricted access' );

class JFormFieldloadCSSJSAdmin extends JFormField
{
    protected $type = 'loadCSSJSAdmin';

	protected function getInput()
	{
		require_once dirname(dirname(__FILE__)).'/defined.php';
		$doc = JFactory::getDocument();
		$doc->addStyleSheet(JURI::root().'modules/'.ST_NAME.'/assets/css/admin.css');
		
		return '';
	}

	/**
	 * Method to get the field label markup.
	 *
	 * @return  string  The field label markup.
	 * @since   11.1
	 */
	protected function getLabel()
	{
		return '';
	}
}

?>