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

if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) 
{
	if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) 
	{
		$file = realpath(base64_decode($_SERVER['QUERY_STRING']));
			
		if (is_file($file)) 
		{
			if ($type = trim(strtolower(pathinfo($file, PATHINFO_EXTENSION)))) 
			{
				if ($type == 'css' || $type == 'js') 
				{
					if ($type == 'css') header('Content-type: text/css; charset=UTF-8');
					if ($type == 'js') header('Content-type: application/x-javascript');
					header('Cache-Control: max-age=86400');
					header('Content-Encoding: gzip');
					echo gzencode(@file_get_contents($file));	
				}
			}
		}
	}	
}
