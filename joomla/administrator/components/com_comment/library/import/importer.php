<?php
/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date       : 11.03.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');
/**
 * Class ccommentImporter
 *
 * @since 5.0
 */
abstract class ccommentImporter
{
	/**
	 * Checks if the component exist
	 *
	 * @return mixed
	 */
	public abstract function exist();

	/**
	 * Imports the comments
	 *
	 * @return mixed
	 */
	public abstract function import();

	/**
	 * Updates the database
	 *
	 * @return mixed
	 */
	public function updateParent()
	{
		$db = JFactory::getDbo();

		// Importparentid > 0 and parentid <= 0
		// Parentid = id of the importid = parentid

		$update = $db->getQuery(true);
		$update->update($db->qn('#__comment') . ' AS ' . $db->qn('cupdate'))
			->set($db->qn('cupdate.parentid') . '=' . $db->qn('cselect.id'))
			->innerJoin($db->qn('#__comment') . ' AS ' . $db->qn('cselect'))
			->where($db->qn('cupdate.parentid') . ' <= ' . $db->q(0))
			->where($db->qn('cupdate.importparentid') . ' > ' . $db->q(0));

		$db->setQuery($update);
		$result = $db->execute();

		if ($result)
		{
			/*
			 * set -1 to parentid not found (or because in other component it is 0 and not -1)
			 * it must be -1 in joomlacomment.
			 */
			$update = $db->getQuery(true);
			$update->update($db->qn('#__comment'))->set($db->qn('parentid') . '=' . $db->q(-1))
				->where($db->qn('parentid') . '=' . $db->q(0));
			$db->setQuery($update);
			$result = $db->execute();
		}

		return $result;
	}
}
