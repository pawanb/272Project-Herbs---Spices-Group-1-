<?php
/**
 * @version		$Id: coolfeed.php 100 2012-04-14 17:42:51Z trung3388@gmail.com $
 * @copyright	JoomAvatar.com
 * @author		Nguyen Quang Trung
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 * @package		Avatar Dream Framework Template
 * @facebook 	http://www.facebook.com/pages/JoomAvatar/120705031368683
 * @twitter	    https://twitter.com/#!/JoomAvatar
 * @support 	http://joomavatar.com/forum/
 */

// No direct access
defined('_JEXEC') or die;

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldAvatarAssets extends JFormField
{
	protected $type = 'AvatarAssets';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 * @since   11.1
	 */
	protected function getInput()
	{
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
		$document = JFactory::getDocument();
		$document->addScript(dirname(JURI::base()).'/templates/'.$this->element['template'].'/core/assets/js/avatar_template_admin.js');
		return '';
	}

	/**
	 * Method to get the field title.
	 *
	 * @return  string  The field title.
	 * @since   11.1
	 */
	protected function getTitle()
	{
		return $this->getLabel();
	}
}
