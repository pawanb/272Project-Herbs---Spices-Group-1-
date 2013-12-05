<?php
/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
if ($this->error->getCode() == 404) {
	$params = JFactory::getApplication()->getTemplate(true)->params;
	header('Location:index.php?option=com_content&view=article&id='.$params->get('404_article').'&Itemid='.$params->get('404_itemid'));
}
