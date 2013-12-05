<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.filesystem.folder');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of folder
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldFolderListFull extends JFormFieldList
{

	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	public $type = 'FolderListFull';
	
	public function __construct($form = null) 
	{
		$folders = JRequest::getVar('folder', array());
		if (count($folders)) {
			$list = array();
			foreach ($folders as $k => $v) {
				$list[$v] = JFolder::files(JPATH_ROOT.'/'.$v, '(.jpg|.jpeg|.gif|.png)$');
			}
			echo '{st-image-load}'.json_encode($list).'{/st-image-load}'; die();
		}
		
		// load saved images
		$saved = JRequest::getVar('loadImage', '');
		
		if ($saved) {
			require_once dirname(dirname(__FILE__)).'/stContentShowcase.php';
			$params = stContentShowcase::getModuleParams();
			echo '{st-image-load}'.json_encode($params).'{/st-image-load}'; die();
		} 
	}
	
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
			$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		}
		
		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration('
			window.addEvent("domready", function(){
				// load image from data 
				var savedData = {params: {}}
				var wrapper = new Element("div", {id: "st-wrapper", class: "row-fluid"});
				wrapper.inject($("jform_params_folder_category"), "after");
				
				var wrapImage = new Element("div", {id: "wrap-image-source", class: "wrap-image-loaded span6"});
				wrapImage.inject(wrapper, "inside");
				
				var wrapImage = new Element("div", {id: "wrap-image-saved", class: "wrap-image-loaded span6"});
				wrapImage.inject(wrapper, "inside");
				
				var myRequest = new Request({
				    url: document.URL.clean().replace("#", "") + "&loadImage=true",
				    method: "get",
				    onSuccess: function(responseText){
						var images = responseText.substring(responseText.indexOf("{st-image-load}") + 15, responseText.indexOf("{/st-image-load}")),
						oImages = JSON.decode(images);
						savedData.params = oImages;
						var html = "";
						html += "<h2>Album</h2>";
						html += "<ul class=\"list-image-loaded\">";
						if (oImages) 
						{
							oImages.folder_image.each(function(el, index){
									if (el != "") 
									{
										el =  el.replace("\\\", "/");
										html += "<li><img style=\"width: 100%;\" src=\"'.JURI::root().'"+ el +"\"/>";	
										html += "<div class=\"info\">";
										html += "<strong>Title</strong><br/><input name=\"jform[params][folder_image][]\" type=\"hidden\" value=\""+ el +"\"/>";
										html += "<input name=\"jform[params][folder_ititle][]\" type=\"text\" value=\""+ oImages.folder_ititle[index] +"\"/>";
										html += "<strong>Link</strong><br/><input name=\"jform[params][folder_ilink][]\" type=\"text\" value=\""+ oImages.folder_ilink[index] +"\"/>";
										html += "<strong>Introtext</strong><br/><textarea cols=\"30px\" rows=\"5\" name=\"jform[params][folder_iintrotext][]\">" + oImages.folder_iintrotext[index] + "</textarea>";
										html += "</div>";
										html += "<div class=\"btn-group st-button-group\">";
										html +=	"		<div class=\"btn select\">Select</div>";
										html +=	"		<div class=\"btn edit\">Edit</div>";
										html +=	"		<div class=\"btn remove\">Remove</div>";
										html +=	"</div></li>";
									}
							});
						}
						html += "</ul>";	
						
						$("wrap-image-saved").set("html",html);
						
						$$("#wrap-image-saved .list-image-loaded li .btn-group > *").addEvent("click", function(){
							var el = $(this);
							var contain = $(this).getParent().getParent();
							
							if (el.hasClass("edit")) {
								contain.toggleClass("display-info");	
							} else if (el.hasClass("remove")) {
								contain.toggleClass("removed");
								if (contain.hasClass("removed")) {
									contain.getElements("input, textarea").setProperty("disabled", "disabled");
								} else {
									contain.getElements("input, textarea").removeProperty("disabled");
								}
							}
						});
						
						
					}
				});
				
				myRequest.send();
					setTimeout(function(){
						$("jform_params_folder_category").setStyle("display", "block");
						$("jform_params_folder_category_chzn").setStyle("display", "none");
					}, 1000);
					$("jform_params_folder_category").addEvent("mouseup", function(event){
						event.preventDefault();
						var moduleParams = savedData.params,
						folders = $("jform_params_folder_category").getSelected(),
						string = "";
						
						folders.each(function(el){
							string += "&folder[]=" + encodeURIComponent(el.value);
						});
						
						$(this).setProperty("href", document.URL.clean().replace("#", "") + string);
						
						var myRequest = new Request({
						    url: document.URL.clean().replace("#", "") + string,
						    method: "get",
						    onSuccess: function(responseText){
						    	var images = responseText.substring(responseText.indexOf("{st-image-load}") + 15, responseText.indexOf("{/st-image-load}")),
								oImages = JSON.decode(images),
								html = "<h2>Source</h2>";
								
								Object.each(oImages, function(value, key){
									html += "<h2>" + key + "</h2>";
									html += "<ul class=\"list-image-loaded\">";
									value.each(function(el){
										try 
										{
											var imagePath = (key.slice(1) + "/" + el).replace(/\134/g, "/");
											var imageUrl = "'.JURI::root().'" + imagePath;
											
											if (!moduleParams || moduleParams.folder_image.indexOf(imagePath) < 0) 
											{
												
												html += "<li><img style=\"width: 100%;\" src=\" "+ imageUrl +" \" />";	
												html += "<div class=\"info\"><strong>Title</strong><br/><input disabled name=\"jform[params][folder_image][]\" type=\"hidden\" value=\""+ imagePath +"\">";
												html += "<input disabled name=\"jform[params][folder_ititle][]\" type=\"text\" value=\""+ el +"\">";
												html += "<strong>Link</strong><br/><input disabled name=\"jform[params][folder_ilink][]\" type=\"text\" value=\""+ imageUrl +"\">";
												html += "<strong>Introtext</strong><br/><textarea disabled cols=\"30px\" rows=\"5\" name=\"jform[params][folder_iintrotext][]\"></textarea>";
												html += "</div>";
												html += "<div class=\"btn-group st-button-group\">";
												html +=	"		<div class=\"btn select\">Add</div>";
												html +=	"		<div class=\"btn edit\">Edit</div>";
												html +=	"		<div class=\"btn remove\">Remove</div>";
												html +=	"</div></li>";	
											}
										} catch (e) {
											
										}
										
									});
									
									html += "</ul>";
								});
								
								$("wrap-image-source").set("html", html);
								
								$$("#wrap-image-source .list-image-loaded li .btn-group > *").addEvent("click", function(){
									var el = $(this);
									var contain = $(this).getParent().getParent();
									
									if (el.hasClass("edit")) {
										contain.toggleClass("display-info");	
									} else if (el.hasClass("select")) {
										contain.inject($$("#wrap-image-saved ul.list-image-loaded")[0], "inside");
										contain.getElements("input, textarea").removeProperty("disabled");
										moduleParams.folder_image.push(contain.getElement("input[name=\"jform[params][folder_image][]\"]").get("value"));
									} else if (el.hasClass("remove")) {
										contain.toggleClass("removed");
										if (contain.hasClass("removed")) {
											contain.getElements("input, textarea").setProperty("disabled", "disabled");
										} else {
											contain.getElements("input, textarea").removeProperty("disabled");
										}
									}
									
								});
							}
						});
						
						myRequest.send();
					});
			
			});
		');
		
		return implode($html);
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

		// Initialize some field attributes.
		$filter = (string) $this->element['filter'];
		$exclude = (string) $this->element['exclude'];
		$hideNone = (string) $this->element['hide_none'];
		$hideDefault = (string) $this->element['hide_default'];
		$base 		= JPATH_ROOT;
		// Get the path in which to search for file options.
		$path = (string) $this->element['directory'];
		if (!is_dir($path))
		{
			$path = JPATH_ROOT . '/' . $path;
		}

		// Prepend some default options based on field attributes.
		if (!$hideNone)
		{
			$options[] = JHtml::_('select.option', '-1', JText::alt('JOPTION_DO_NOT_USE', preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)));
		}
		if (!$hideDefault)
		{
			$options[] = JHtml::_('select.option', '', JText::alt('JOPTION_USE_DEFAULT', preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)));
		}

		// Get a list of folders in the search path with the given filter.
		$folders = JFolder::folders($path, $filter, true, true);

		// Build the options list from the list of folders.
		if (is_array($folders))
		{
			foreach ($folders as $folder)
			{
				$folder = str_replace(JPATH_ROOT, '', $folder);
				// Check to see if the file is in the exclude mask.
				if ($exclude)
				{
					if (preg_match(chr(1) . $exclude . chr(1), $folder))
					{
						continue;
					}
				}

				$options[] = JHtml::_('select.option', $folder, $folder);
			}
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
