<?php

/***************************************************************
*  Copyright notice
*
*  Copyright 2013 Daniel Dimitrov. (http://compojoom.com)
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
***************************************************************/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class ccommentConfig {
	protected $component = null;
	private static $instances = array();

	protected function __construct() {}
	protected function __clone() {}

	/**
	 * @param $component
	 * @return mixed
	 */
	public static function getConfig($component) {
		if(!isset(self::$instances[$component])) {
			self::$instances[$component] = self::_createConfig($component);
		}
		return self::$instances[$component];
	}

	/**
	 * @param $component
	 * @return JRegistry
	 * @throws Exception
	 */
	private static function &_createConfig($component) {
		$database = JFactory::getDBO();
		
		$query = 'SELECT * FROM ' . $database->qn('#__comment_setting')
			. ' WHERE component = ' . $database->Quote($component);;

		$database->setQuery($query);
		$row = $database->loadObject();

		if(!$row) {
			throw new Exception('No ccomment configuration exist for ' . $component);
		}

		$config = new JRegistry($row->params);

		// load the global parameters
		$params = JComponentHelper::getParams('com_comment');
		$config->loadArray($params->toArray());

		// we need arrays of those values
		$config->set('global.censorship_word_list', self::censorWords($config->get('global.censorship_word_list')));
		$config->set('basic.exclude_content_items', self::makeArray($config->get('basic.exclude_content_items')));
		$config->set('basic.disable_additional_comments', self::makeArray($config->get('basic.disable_additional_comments')));

		return $config;
	}

	/**
	 * @param $string
	 * @return array
	 */
	private static function makeArray($string) {
		$strings = array();
		if($string) {
			$strings = explode(',', $string);
			foreach($strings as $key => $value){
				$strings[$key] = trim($value);
			}
		}

		return $strings;
	}

	/**
	 * Transforms the censorship words from a string to an array of words
	 * @param $censorshipWords
	 * @return array
	 */
	private static function censorWords($censorshipWords) {
		$censorshipList = array();

		if ($censorshipWords) {
			$censorshipWords = explode(',', $censorshipWords);
			if (is_array($censorshipWords)) {
				foreach($censorshipWords as $word) {
					$word = trim($word);
					if (JString::strpos($word, '=')) {
						$word = explode('=', $word);
						$from = trim($word[0]);
						$to   = trim($word[1]);
					} else {
						$from = $word;
						$to   = ccommentHelperStrings::str_fill(JString::strlen($word), '*');
					}
					$censorshipList[$from] = $to;
				}
			}
		}
		return $censorshipList;
	}

}