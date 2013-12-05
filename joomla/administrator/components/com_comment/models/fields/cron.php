<?php
/**
 * @package - com_comment
 * @author: DanielDimitrov - compojoom.com
 * @date: 01.05.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

class JFormFieldCron extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 */
	protected $type = 'cron';


	protected function getInput()
	{
		$url = Juri::root() . 'index.php?option=com_comment&task=queue.cron&format=raw&total=10';
		return '<a href="'.$url.'" target="_blank" style="display:inline-block; padding-top: 5px" class="small">'.$url.'</a>';
	}

}
