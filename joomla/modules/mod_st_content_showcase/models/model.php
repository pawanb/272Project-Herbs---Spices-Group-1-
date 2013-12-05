<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

class stContentShowcaseModel {
	
	public $_model;  
	public $_prefix = 'stContentShowcaseModel';
	public $_params;
	
	public function __construct($params = array()) 
	{
		$this->_params = $params;
	}
	
	/**
	 * @return list items
	 **/
	public function getList() 
	{
		return $this->_items = $this->_items();
	}
	
	/**
	 * @return array categories 
	 */
	public function getCategories() {
		return $this->_categories = array();
	}
	
	/**
	 *  return items
	 */
	public function _items() {
		return array();
	}
}
