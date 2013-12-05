<?php

/* * *************************************************************
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
 * ************************************************************* */

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

$user = JFactory::getUser();

if (!$user->authorise('core.manage', 'com_comment')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

require_once(JPATH_COMPONENT_ADMINISTRATOR. '/version.php');
require_once JPATH_COMPONENT_ADMINISTRATOR.'/liveupdate/liveupdate.php';
if(JRequest::getCmd('view','') == 'liveupdate') {
	JToolBarHelper::preferences( 'com_comment' );
    LiveUpdate::handleRequest();
    return;
}

JLoader::discover('ccomment', JPATH_COMPONENT_ADMINISTRATOR . '/library');
JLoader::discover('ccommentHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');
JLoader::discover('ccommentHelper', JPATH_COMPONENT_SITE . '/helpers');

require_once(JPATH_COMPONENT_ADMINISTRATOR .'/controller.php' );

$jlang = JFactory::getLanguage();
$jlang->load('com_comment', JPATH_SITE, 'en-GB', true);
$jlang->load('com_comment', JPATH_SITE, $jlang->getDefault(), true);
$jlang->load('com_comment', JPATH_SITE, null, true);
$jlang->load('com_comment', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('com_comment', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('com_comment', JPATH_ADMINISTRATOR, null, true);


require_once('toolbar.comment.php');

$input = JFactory::getApplication()->input;

$controller = JControllerLegacy::getInstance('ccomment');
$controller->execute($input->getCmd('task'));
$controller->redirect();