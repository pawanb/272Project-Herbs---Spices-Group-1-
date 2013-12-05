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
class AvatarDevice {
	public static function detectDevice()
	{
		if (preg_match("/(alcatel|
	    					amoi|android|avantgo|
	    					blackberry|benq|
	    					cell|cricket|
	    					docomo|
	    					elaine|
	    					htc|
	    					iemobile|iphone|ipad|ipaq|ipod|
	    					j2me|java|
	    					midp|mini|mmp|mobi|motorola|
	    					nec-|nokia|
	    					palm|panasonic|philips|phone|
	    					sagem|sharp|sie-|smartphone|sony|symbian|
	    					t-mobile|telus|
	    					up\.browser|up\.link|
	    					vodafone|
	    					wap|webos|wireless
	    					|xda|xoom|
	    					zte
	    					)/i", $_SERVER['HTTP_USER_AGENT'])) {
	        return true;
	 	}
	        return false;
	}
}