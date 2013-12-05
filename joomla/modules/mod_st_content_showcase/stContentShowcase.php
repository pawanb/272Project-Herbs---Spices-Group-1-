<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

require_once 'defined.php';
class stContentShowcase {
	
	public static function getModel($model, $params = array()) 
	{
		require_once ST_MODEL_PATH.DIRECTORY_SEPARATOR.'model.php';
		$modelPath = ST_MODEL_PATH.DIRECTORY_SEPARATOR.$model.DIRECTORY_SEPARATOR.$model.'.php';
		
		if (version_compare(JVERSION, '3.0.0', '>')) {
			$modelPath = ST_MODEL_PATH.DIRECTORY_SEPARATOR.$model.DIRECTORY_SEPARATOR.$model.'.'.JVERSION.'.php';
			if (!JFile::exists(ST_DIR.$modelPath)) {
				$modelPath = ST_MODEL_PATH.DIRECTORY_SEPARATOR.$model.DIRECTORY_SEPARATOR.$model.'.3.x.x'.'.php';
				if (!JFile::exists(ST_DIR.$modelPath)) {
					$modelPath = ST_MODEL_PATH.DIRECTORY_SEPARATOR.$model.DIRECTORY_SEPARATOR.$model.'.php';			
				}
			}
		}
		
		require_once $modelPath;
		
		$class = ST_MODEL_PREFIX.$model;
		return new $class($params);
	}
	
	public static function getModuleParams() 
	{
		$db = JFactory::getDbo();
		$id = JRequest::getInt('id', 0);
		$query = $db->getQuery(true);
		$query->select('*')
		->from('#__modules')
		->where('id = '.$id)
		->where('module = '. $db->quote(ST_NAME));
		
		$db->setQuery($query);
		
		$result = $db->loadObject();
		
		return isset($result->params) ? json_decode($result->params) : false;		
	}
}
