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

class JFormFieldAvatarGoogleFont extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 *
	 * @since  11.1
	 */
	protected $type = 'AvatarGoogleFont';
	protected $_googleFont = array();
	protected $_apiKey = 0;
	
	public function __construct($form = null) 
	{
		parent::__construct($form);
		require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'param.php';
		$idTemplate = JRequest::getInt('id', 0); 	
		$paramT = AvatarParam::template($idTemplate);
		
		if (isset($paramT->google_font_api_key)) {
			$this->_apiKey = $paramT->google_font_api_key;
		}
		
		$this->getGoogleFont();
	}

	/**
	 * Method to get google fonts from google
	 * @return google font object
	 */
	protected function getGoogleFont()
	{
		if (count($this->_googleFont) < 1 ) 
		{
			$url = 'https://www.googleapis.com/webfonts/v1/webfonts?key='.$this->_apiKey;
			$result = json_decode(@file_get_contents($url));
			
			if (is_object($result) && is_array($result->items)) {
				$this->_googleFont = $result->items;
			} else {
				$this->_googleFont = array();
			}
		}
		
		return $this->_googleFont;
	}
	
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
		$options = array();
		$options[] 	= JHtml::_('select.option', 0, JText::_('AVATAR_TEMPLATE_CORE_GOOGLE_FONT_SELECT'));
		$font = array();
		if (is_array($this->_googleFont)) 
		{
			foreach ($this->_googleFont as $item) {
				$options[] 	= JHtml::_('select.option', $item->family, $item->family);
				$font[$item->family] = $item;
			}
			
			$this->_googleFont = $font;
		}
		
		return $options;
	}
	
	/**
	 * Method to get the field input markup for a generic list.
	 * Use the multiple attribute to enable multiselect.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		// Initialize variables.
		$html = array();
		$attr = '';

		// Initialize some field attributes.
		$attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';

		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ((string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true')
		{
			$attr .= ' disabled="disabled"';
		}

		$attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';

		// Initialize JavaScript field attributes.
		$attr .= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

		// Get the field options.
		$options = (array) $this->getOptions();

		// Create a read-only list (no name) with a hidden input to store the value.
		if ((string) $this->element['readonly'] == 'true')
		{
			$html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);
			$html[] = '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '"/>';
		}
		// Create a regular list.
		else
		{
			$document = JFactory::getDocument();
			$document->addScriptDeclaration('
				var avatarGoogleFont = '.json_encode($this->_googleFont).'
				function changeFont(el) {
					var value 		= el.options[el.selectedIndex].value;
					var elID 		= el.id.replace("_family", "");
					var elVariant 	= $(elID + "_variant");
					var elSubset 	= $(elID + "_subset");
					var elHidden 	= $(elID);
					
					elVariant.innerHTML = "";
					elSubset.innerHTML = "";
					
					if (value.toString() == "0") 
					{
						elHidden.set("html", "[]");
						return true;
					} 
					else 
					{
						if (avatarGoogleFont[value] != undefined) 
						{
							var variants 	= avatarGoogleFont[value].variants;
							var subsets 	= avatarGoogleFont[value].subsets;
							
							variants.each (function(v){
								var option = "<option value=\""+ v +"\" >"+ v +"</option>";
								elVariant.innerHTML = elVariant.innerHTML + option;
							});
							
							subsets.each (function(s){
								var option = "<option value=\""+ s +"\" >"+ s +"</option>";
								elSubset.innerHTML = elSubset.innerHTML + option;
							});
							
							elHidden.set("html", JSON.encode([value, ((variants.length) ? variants[0] : ""), ((subsets.length) ? subsets[0] : "")]));
						}
					}
				}
				
				function changeVariant(el) {
					var elID = el.id;
					var elHidden = $(elID.replace("_variant", ""));
					value = JSON.decode(elHidden.get("html"));
					//value[1] = el.options[el.selectedIndex].value;
					value[1] = el.getSelected().get("value").join();
					elHidden.set("html", JSON.encode(value));
				}
				
				function changeSubset(el) {
					var elID = el.id;
					var elHidden = $(elID.replace("_subset", ""));
					value = JSON.decode(elHidden.get("html"));
					value[2] = el.options[el.selectedIndex].value;
					elHidden.set("html", JSON.encode(value));
				}
				
				
			');
			$values = json_decode($this->value);
			
			$html[] = '<script>Joomla.submitbutton = function(task){
					
					$$(".avatar-google-font-input").each(function(gbutton){
						gbutton.disabled = false;
					});
					
					if (task == "style.cancel" || document.formvalidator.isValid(document.id("style-form"))) {
						Joomla.submitform(task, document.getElementById("style-form"));
					}

				}</script><textarea class="avatar-google-font-input" rows="2" cols="30" disabled="disabled" id="'. $this->id .'" name="' . $this->name . '">'.$this->value.'</textarea>';
			$html[] = JHtml::_('select.genericlist', $options, 'jform[params]['.$this->fieldname.'_family]', trim($attr), 'value', 'text', $this->value, $this->id . '_family');
			$html[] = JHtml::_('select.genericlist', array(), 'jform[params]['.$this->fieldname.'_variant]', 'size="10" multiple="true" onchange="changeVariant(this)" ', 'value', 'text', $this->value, $this->id . '_variant');
			$html[] = JHtml::_('select.genericlist', array(), 'jform[params]['.$this->fieldname.'_subset]', ' onchange="changeSubset(this)" ', 'value', 'text', $this->value, $this->id . '_subset');
			
		}

		return implode($html);
	}
}
