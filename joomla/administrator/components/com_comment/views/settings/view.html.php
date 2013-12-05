<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       11.04.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.viewlegacy');

/**
 * Class ccommentViewSettings
 *
 * @since  5
 */
class CcommentViewSettings extends JViewLegacy
{
	/**
	 * Display function
	 *
	 * @param   string  $tmpl  - the template
	 *
	 * @return mixed|void
	 */
	public function display($tmpl = null)
	{
		$this->rows = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		parent::display($tmpl);
	}

	/**
	 * The choose layout
	 *
	 * @return void
	 */
	public function choose()
	{
		$model = $this->getModel('settings');

		$plugins = $model->getAvailablePlugins();

		foreach ($plugins as $value)
		{
			$values[$value] = $value;
		}

		$this->plugins = JHtml::_('select.genericlist', $values, 'component');

		parent::display('choose');
	}
}
