<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

class stContentShowcaseModelFolder extends stContentShowcaseModel {
	
	public function  getCategories () 
	{
		return $folders = $this->_params->get('folder_category', array());	
	}	
	public function _items() 
	{
		parent::_items();
		$items = array();
		$params = $this->_params;
			
		if ($params->get('folder_sync', 0)) 
		{
			$folders = $params->get('folder_category', array());
			
			foreach ($folders as $key => $value) 
			{
				$value = str_replace('\\', '/', $value);
				($value[0] == '/') ? $value =  substr($value, 1) : '';
				
				$files = JFolder::files(JPATH_ROOT.'/'.$value, '(.jpg|.png|.jpeg|.gif)$');
				
				foreach ($files as $k => $file) 
				{
					if (count($items) > $params->get('count', 10)) {
						break;
					}
					$filePart = pathinfo($file);
					$item = new stdClass;
					$item->title = $filePart['filename'];
					$item->image = JURI::root().$value."/".$file;
					$item->image_intro = $item->image;
					$item->image_intro_caption = $filePart['filename'];
					$item->image_intro_alt = $filePart['filename'];
					$item->image_large = $item->image;
					$item->link = JURI::root().$value."/".$file;
					$item->introtext = $filePart['filename'];
					$item->category = $value;
					$items[] = $item;
				}
			}
		} 
		else 
		{
			$images = $params->get('folder_image');
			$titles = $params->get('folder_ititle');
			$links = $params->get('folder_ilink');
			$intros  = $params->get('folder_iintrotext');
			
			foreach ($images as $key => $value) 
			{
				if ($value) 
				{
					if (count($items) > $params->get('count', 10)) {
						break;
					}
					$value = str_replace('\\', '/', $value);
					($value[0] == '/') ? $value =  substr($value, 1) : '';
					$item  = new stdClass;
					$item->title = $titles[$key];
					$item->image = JURI::root().$value;
					$item->image_intro = $item->image;
					$item->image_intro_caption = $titles[$key];
					$item->image_intro_alt = $titles[$key];
					$item->image_large = $item->image;
					$item->link = ($links[$key]) ? $links[$key] : JURI::root().$value;
					$item->introtext = $intros[$key];
					$item->category = dirname($value);
					$items[] = $item;
				}
		    }
		}
		
		return $items;
	}
}
