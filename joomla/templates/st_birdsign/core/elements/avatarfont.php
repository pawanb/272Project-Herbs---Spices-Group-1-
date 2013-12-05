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

/**
 * Form Field class for the Joomla Platform.
 * Supports a one line text field.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @link        http://www.w3.org/TR/html-markup/input.text.html#input.text
 * @since       11.1
 */
class JFormFieldAvatarFont extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 *
	 * @since  11.1
	 */
	protected $type = 'AvatarFont';

/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = parent::getOptions();
		$options[] 	= JHtml::_('select.option', '', JText::_('JNO'));
		$options[] 	= JHtml::_('select.option', '"Lucida Grande", "Lucida Sans Unicode", Arial, Verdana, sans-serif', JText::_('AVATAR_TEMPLATE_CORE_FONT_LUCIDA'));
		$options[] 	= JHtml::_('select.option', 'Georgia, serif', JText::_('AVATAR_TEMPLATE_CORE_FONT_GEORGIA'));
		$options[] 	= JHtml::_('select.option', '"Times New Roman", Times, serif', JText::_('AVATAR_TEMPLATE_CORE_FONT_TIMES_NEW_ROMAN'));
		$options[] 	= JHtml::_('select.option', '"Trebuchet MS", Helvetica, sans-serif', JText::_('AVATAR_TEMPLATE_CORE_FONT_TREBUCHET'));
		$options[] 	= JHtml::_('select.option', 'Tahoma, Geneva, sans-serif', JText::_('AVATAR_TEMPLATE_CORE_FONT_TAHOMA'));
		$options[] 	= JHtml::_('select.option', 'Helvetica, sans-serif', JText::_('AVATAR_TEMPLATE_CORE_FONT_HELVETICA'));
		
		return $options;
	}
}
