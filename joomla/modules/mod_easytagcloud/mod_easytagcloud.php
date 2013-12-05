<?php
/**
* @version      2.4
* @package		com_easytagcloud
* @author       Kee Huang
* @copyright	Copyright(C)2013 Joomla Tonight. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Easytagcloud is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

// no direct access

defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$taghelper = new modTagcloudHelper;
$easytagcloud_params = $taghelper->getTags($params);

require(JModuleHelper::getLayoutPath('mod_easytagcloud'));
?>