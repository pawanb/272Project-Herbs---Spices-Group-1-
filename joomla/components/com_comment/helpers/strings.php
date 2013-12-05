<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 28.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
 
defined('_JEXEC') or die('Restricted access');

class ccommentHelperStrings {

	public static function str_fill($len, $filler) {
		$result = "";
		for ($i = 0; $i < $len; $i++)
			$result .= $filler;
		return $result;
	}
}