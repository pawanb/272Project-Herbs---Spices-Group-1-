<?php
/**
 * @author Daniel Dimitrov - http://compojoom.com
 * @version 1.0
 *
 * This file is part of Adminpraise.
 *
 * Adminpraise is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Adminpraise is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Adminpraise.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

$language = JFactory::getLanguage();
$language->load('com_comment.sys', JPATH_ADMINISTRATOR, null, true);

$input = JFactory::getApplication()->input;
$view = $input->getCmd('view', '');
if(!$view) {
	$command = $input->getCmd('task');
	if($command) {
		if (strpos($command, '.') !== false)
		{
			list ($view, $task) = explode('.', $command);
		}
	}
}
$subMenus = array (
	'dashboard' => 'COM_COMMENT_DASHBOARD',
    'comments' => 'COM_COMMENT_MANAGE_COMMENTS',
    'settings' => 'COM_COMMENT_SETTINGS',
    'import' => 'COM_COMMENT_IMPORT',
	'liveupdate' => 'COM_COMMENT_LIVEUPDATE'
);

foreach ($subMenus as $key => $name) {
    $active = ( $view == $key );
	JSubMenuHelper::addEntry(JText::_($name), 'index.php?option=com_comment&view=' . $key, $active);
}