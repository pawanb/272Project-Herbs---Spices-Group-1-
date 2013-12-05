<?php
/**
 * @package      ITPrism Modules
 * @subpackage   ITPShare
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2013 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

JLoader::register('ItpShareHelper', dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$doc = JFactory::getDocument();
/** $doc JDocumentHTML **/

// Loading style.css
if($params->get("loadCss")) {
    $doc->addStyleSheet("modules/mod_itpshare/style.css");
}

// URL
$url    = JURI::getInstance()->toString();
$title  = $doc->getTitle();

// Convert the url to short one
if($params->get("shortener_service")) {
	$url = ItpShareHelper::getShortUrl($url, $params);
}
        
$title  = JString::trim($title);
require JModuleHelper::getLayoutPath('mod_itpshare', $params->get('layout', 'default'));