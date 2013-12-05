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

class AvatarParam extends JObject {
	
	public static function template($id) 
	{
		$db		= JFactory::getDbo();
		$result	= false;
		
		// Get the template information.
		$db->setQuery(
			'SELECT *' .
			' FROM #__template_styles' .
			' WHERE id = '.(int) $id
		);
		
		$result = $db->loadObject();
		
		if ($result->params) {
			return json_decode($result->params);
		}
		
		return false;
	}
}
	