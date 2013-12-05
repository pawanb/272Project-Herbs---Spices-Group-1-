<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       03.09.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellegacy');

/**
 * Class ccommentModelImport
 *
 * @since  5.0
 */
class ccommentModelImport extends JModelLegacy
{
	/**
	 * Supported import systems
	 *
	 * @return array
	 */
	public function supportedImports()
	{
		jimport('joomla.filesystem.folder');
		$path = JPATH_COMPONENT . '/library/import/components/';
		$components = array();

		if (file_exists($path))
		{
			JLoader::register('ccommentImport', JPATH_COMPONENT_ADMINISTRATOR . '/library/import/import.php');
			$imports = JFolder::files($path);

			foreach ($imports as $import)
			{
				$component = str_replace('.php', '', $import);
				$import = new CCommentImport($component);
				$components[$component] = $import->exist();
			}
		}

		return $components;
	}

	/**
	 * Gets the table list
	 *
	 * @return array
	 */
	public function getTables()
	{
		$tables = ccommentHelperTable::getTableList();
		$options = array('');

		foreach ($tables as $key => $value)
		{
			$options[$value] = $value;
		}

		return $options;
	}

	/**
	 * Gets the columns from the table
	 *
	 * @return array
	 */
	public function getColumns()
	{
		$table = JFactory::getApplication()->input->getCmd('table');
		$options = array('');

		if ($table)
		{
			$columns = ccommentHelperTable::getTableColumns($table);

			foreach ($columns as $value)
			{
				$options[$value->Field] = $value->Field;
			}
		}

		return $options;
	}

	/**
	 * The import
	 *
	 * @return mixed
	 */
	public function import()
	{
		$input = JFactory::getApplication()->input;
		$component = $input->getCmd('component');
		$table = $input->getCmd('table');
		$columns = $input->get('data', '', 'array');
		$db = JFactory::getDbo();
		$insert = $db->getQuery('true');
		$select = $db->getQuery('true');
		$into = array();
		$from = array();

		foreach ($columns as $key => $value)
		{
			if ($key == 'componentfield')
			{
				$into[] = $db->qn('component');

				if ($value)
				{
					$select->where($db->qn('f.' . $value) . '=' . $db->q($component));
					$from[] = $db->qn($value);
				}
				else
				{
					$from[] = $db->q($component);
				}
			}
			elseif ($key == 'id')
			{
				$into[] = $db->qn('importid');
				$from[] = $db->qn($value);
			}
			elseif ($key == 'parentid')
			{
				$into[] = $db->qn('importparentid');

				if ($value)
				{
					$from[] = $db->qn($value);
				}
				else
				{
					$from[] = $db->q('-1');
				}
			}
			else
			{
				if ($value)
				{
					$into[] = $db->qn($key);
					$from[] = $db->qn($value);
				}
			}
		}



		$into[] = $db->qn('importtable');
		$from[] = $db->q($table);

		$select->select(implode(',', $from))->from($db->qn($table) . ' AS f');

		// INSERT and save source id and source parentid in importid/importparentid field.
		$insert->insert($db->qn('#__comment'))->columns(implode(',', $into))
			->values($select);

		$db->setQuery($insert);
		$result = $db->execute();

		if ($result)
		{
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
		}

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
