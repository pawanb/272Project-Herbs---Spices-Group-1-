<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once

require_once dirname(__FILE__).'/defined.php';
require_once dirname(__FILE__).'/stContentShowcase.php';
$appModule = new stContentShowcase();
$modelName = $params->get('source', 'article');

if ($modelName < 0) {
	return;
}

$model = $appModule->getModel($modelName, $params);
$list = $model->getList();
$categories = $model->getCategories();

if (!count($list)) {
	return;
}

require JModuleHelper::getLayoutPath('mod_st_content_showcase', $params->get('layout', 'default'));
