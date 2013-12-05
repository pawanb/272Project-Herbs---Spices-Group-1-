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
class JFormFieldAvatarAbout extends JFormField
{
	protected $type = 'AvatarAbout';

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
		$document->addStyleSheet(dirname(JURI::base()).'/templates/'.$this->element['template'].'/core/assets/css/admin.css');
		// Initialise variables.
		$label = '';

		$label .= '<h1><a title="Avatar - Template Framework - easy to build a website" target="_blank" href="http://www.submit-templates.com">'. $this->element['fullname'] .' '. $this->element['version'] . ' ' . $this->element['edition'] . '</a></h1>';
		$label .= '<ul class="avatar-template-core-about">';
		$label .= '<li><strong>'. JText::_('AVATAR_TEMPLATE_CORE_HOME_PAGE') . '</strong> : <a title="Joomla Extensions, Templates" href="'.$this->element['homepage'].'" target="_blank">' . $this->element['homepage'] . '</a></li>';
		$label .= '<li><strong>'. JText::_('AVATAR_TEMPLATE_CORE_SUPPORT') . '</strong> : <a title="Support, services, and Joomla!" href="'.$this->element['support'].'" target="_blank">' . $this->element['support'] . '</a></li>';
		$label .= '<li><strong>'. JText::_('AVATAR_TEMPLATE_CORE_FACEBOOK') . '</strong> : <a title="Like us on Facebook" href="'.$this->element['facebook'].'" target="_blank">' . $this->element['facebook'] . '</a></li>';
		$label .= '<li><strong>'. JText::_('AVATAR_TEMPLATE_CORE_TWITTER') . '</strong> : <a title="Connect to us on Twitter" href="'.$this->element['twitter'].'" target="_blank">' . $this->element['twitter'] . '</a></li>';
		$label .= '</ul>';

		return $label;
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
