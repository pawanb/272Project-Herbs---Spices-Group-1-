<?php
/**
 * @package    - com_comment
 * @author     : DanielDimitrov - compojoom.com
 * @date: 16.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.viewlegacy');

class ccommentViewAjaxcrawler extends JViewLegacy
{

	public function display($tpl = null)
	{
		return $this->loadTemplate();
	}

}