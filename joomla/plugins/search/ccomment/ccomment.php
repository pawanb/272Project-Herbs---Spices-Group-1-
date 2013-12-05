<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Search.contacts
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * CComment Search plugin
 *
 * @since  5.0
 */
class PlgSearchCcomment extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Returns the search areas
	 *
	 * @return array An array of search areas
	 */
	public function onContentSearchAreas()
	{
		static $areas = array(
			'ccomment' => 'PLG_SEARCH_CCOMMENT_COMMENTS'
		);

		return $areas;
	}

	/**
	 * CComment Search method
	 * The sql must return the following fields that are used in a common display
	 * routine: href, title, section, created, text, browsernav
	 *
	 * @param   string  $text      - the text to search for
	 * @param   string  $phrase    - phrase
	 * @param   string  $ordering  - the ordering
	 * @param   null    $areas     - the areas
	 *
	 * @return array|mixed
	 */
	public function onContentSearch($text, $phrase = '', $ordering = '', $areas = null)
	{
		$db = JFactory::getDbo();

		if (is_array($areas))
		{
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas())))
			{
				return array();
			}
		}

		$limit = $this->params->def('search_limit', 50);
		$state = array();

		if (!empty($state))
		{
			return array();
		}

		$text = trim($text);

		if ($text == '')
		{
			return array();
		}

		$section = JText::_('PLG_SEARCH_CCOMMENT_COMMENTS');

		switch ($ordering)
		{
			case 'alpha':
				$order = 'a.comment ASC';
				break;

			case 'popular':
				$order = 'a.voting_yes DESC';
				break;
			case 'newest':
				$order = 'a.date DESC';
				break;
			case 'oldest':
				$order = 'a.date ASC';
				break;
			default:
				$order = 'a.comment DESC';
		}

		$text = $db->quote('%' . $db->escape($text, true) . '%', false);

		$query = $db->getQuery(true);


		$query->select(
			'a.id AS id, a.name AS title, a.date AS created, a.comment as text,'
			. $query->concatenate(array($db->quote($section), "a.name"), " / ") . ' AS section,'
			. '\'2\' AS browsernav'
		);

		$query->from('#__comment AS a')
			->where(
				'(a.name LIKE ' . $text . ' OR a.comment LIKE ' . $text
				. ') AND a.published=1 '
			)
			->group('a.id, a.comment, a.name')
			->order($order);

		$db->setQuery($query, 0, $limit);
		$rows = $db->loadObjectList();

		if ($rows)
		{
			foreach ($rows as $key => $row)
			{
				$rows[$key]->href = 'index.php?option=com_comment&task=comment.gotocomment&id=' . $row->id;
				$rows[$key]->text = $row->title;
				$rows[$key]->text .= ($row->text) ? ', ' . $row->text : '';
			}
		}

		return $rows;
	}
}
