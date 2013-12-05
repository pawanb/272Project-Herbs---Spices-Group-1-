<?php
/**
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       01.05.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die ('Restricted access');

JLoader::register('K2Plugin', JPATH_ADMINISTRATOR . '/components/com_k2/lib/k2plugin.php');

/**
 * Class plgK2CompojoomcommentK2
 *
 * @since  5.0
 */
class plgK2Ccomment extends K2Plugin
{
	// Some params
	public $pluginName = 'ccomment';

	public $pluginNameHumanReadable = 'K2 - CComment';

	/**
	 * Renders the comments in k2
	 *
	 * @param   <object>  &$item    - the obejct with k2 item data such as id etc
	 * @param   <object>  &$params  - the component params
	 *
	 * @return string - rendered comments
	 */
	public function onK2CommentsBlock(&$item, &$params)
	{
		JLoader::discover('ccommentHelper', JPATH_SITE . '/components/com_comment/helpers');

		return ccommentHelperUtils::commentInit('com_k2', $item, $params);
	}

	/**
	 * We have to trick com_k2. CComment doesn't have a specific function
	 * that shows only the commentsCounter. It checks if we are in the right view
	 * and if this returns true - then we see the comment form. Since this event
	 * is included everywhere in single view we get 2 comment forms.
	 * That is why we have to trick this event and show the counter only when not in
	 * single view
	 *
	 * @param   <object>  &$item    - the obejct with k2 item data such as id etc
	 * @param   <object>  &$params  - the component params
	 *
	 * @return string - "(number of comments) write comment"
	 */
	public function onK2CommentsCounter(&$item, &$params)
	{
		$input = JFactory::getApplication()->input;
		$option = $input->getCmd('option');
		$view = $input->getCmd('view');

		if ($option == 'com_k2' && $view != 'item')
		{
			JLoader::discover('ccommentHelper', JPATH_SITE . '/components/com_comment/helpers');

			return ccommentHelperUtils::commentInit('com_k2', $item, $params);
		}

		return '&nbsp;';
	}
}
