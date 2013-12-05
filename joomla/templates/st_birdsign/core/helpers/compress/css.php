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
class AvatarCompressCSS extends JObject {
	public $_path;
	/**
	 * compress content
	 */	
	public function compress($path, $file) {
		$this->_path = dirname($path);
		$content = file_get_contents($file);
		return preg_replace_callback('/url\(\s*[\'"]?(?![a-z]+:|\/+)([^\'")]+)[\'"]?\s*\)/i', array($this, 'rewriteURL'), $content);
	}
	
	/**
	 * rewrite url that used in css file.
	 */
	public function rewriteURL($matches) 
	{
		$path = $this->_path.$matches[1];
        $last = '';

        while ($path != $last) {
            $last = $path;
            $path = preg_replace('`(^|/)(?!\.\./)([^/]+)/\.\./`', '', $path);
        }

        return 'url("'.$path.'")';
	}
}