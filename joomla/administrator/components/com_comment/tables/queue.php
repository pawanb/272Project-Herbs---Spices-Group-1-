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

class ccommentTableQueue extends JTable
{

	public function __construct(&$db)
	{
		parent::__construct('#__comment_queue', 'id', $db);
	}

}