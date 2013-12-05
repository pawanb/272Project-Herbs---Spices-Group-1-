<?php

/***************************************************************
*  Copyright notice
*
*  Copyright 2009 Daniel Dimitrov. (http://compojoom.com)
*  All rights reserved
*
*  This script is part of the Compojoom Comment project. The Compojoom Comment project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

defined('_JEXEC') or die('Restricted access');

/**
 * Description of viewhtml
 *
 * @author Daniel Dimitrov
 */
 jimport( 'joomla.application.component.viewlegacy');
class ccommentViewComment extends JViewLegacy {
	public function display($tpl = null) {
		$this->form = $this->get('Form');
//		var_dump($this->form);
		$this->item = $this->get('Item');
//		var_dump($this->item);
//		var_dump($this->form);
//		die();
//		$comment =& $this->get('Data');
//		JFilterOutput::objectHTMLSafe( $comment, ENT_QUOTES, 'comment' );
//		$lists = array();
//		$lists['userid'] = JHTML::_('list.users', 'userid', $comment->userid, 1, NULL, 'name', 0);
		
//		$this->assignRef('comment', $comment);
//		$this->assignRef('lists', $lists);
		parent::display($tpl);
	}
}