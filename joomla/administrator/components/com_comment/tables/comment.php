<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  Copyright 2013 Daniel Dimitrov. (http://compojoom.com)
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
 * ************************************************************* */

defined('_JEXEC') or die('Restricted access');

/*
 * the #__comment table stores all !jocomment comments
 */

class ccommentTableComment extends JTable
{

	public function __construct(&$db)
	{
		parent::__construct('#__comment', 'id', $db);
	}

	/**
	 * @param bool $updateNulls
	 *
	 * @return bool
	 */
	public function store($updateNulls = false)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();
		if ($this->id)
		{
			$this->modified = $date->toSql();
			$this->modified_by = $user->get('id');
		}
		else
		{
			$this->date = $date->toSql();
			$this->unsubscribe_hash = md5(JSession::getFormToken() . time() . mt_rand(1,100));
			$this->moderate_hash = md5($this->ip .JVERSION. JSession::getFormToken() . time() . mt_rand(1,10000));

		}

		return parent::store($updateNulls);
	}
}