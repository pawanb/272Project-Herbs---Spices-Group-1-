<?php

/***************************************************************
 *
 *  Copyright notice
 *
 *  Copyright 2013 Daniel Dimitrov. (http://compojoom.com)
 *  All rights reserved
 *
 *  This script is part of the CompojoomComment project. The CompojoomComment project is
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

class ccommentHelperTree
{

	private static $_counter;
	private static $_new;

	/**
	 * @param $data
	 * @param $seed
	 */
	private static function getSeed($data, $seed)
	{
		self::$_counter++;
		if ($seed) {
			foreach ($seed as $item) {
				$data[$item]->wrapnum = self::$_counter;
				self::$_new[] = $data[$item];
				if (isset($data[$item]->seed) && $data[$item]->seed) {
					self::getSeed($data, $data[$item]->seed);
					$data[$item] = null;
				}
			}
		}
		self::$_counter--;
	}

	/**
	 * @static
	 * @param $data
	 * @return mixed
	 */
	public static function build($data)
	{
		$index = 0;
		self::$_new = null;
		self::$_counter = 0;
		/*
		 * TREE :
		 * 	parents can have several direct children
		 * 	their children can have also their own children etc...
		 *
		 * 	parent
		 * 		|_	child1
		 * 		|		|_	child1.1
		 * 		|		|			|_ child1.1.1
		 * 		|		|			|...
		 * 		|		|_	child1.2
		 * 		|		...
		 * 		|_	child2
		 * 		...
		 *
		 * SEED for one parent is the CHILDS ARRAY
		 */

		/*
		 * FIRST LOOP : prepare datas
		 *
		 * $index is $data key  (we call it: INDEX)
		 *
		 * $old[] : key = comment_id / value = INDEX
		 *
		 * - save INDEX in a new 'treeid' column
		 *
		 * - for all children: replace parentid value by PARENT INDEX value
		 * -> sort must be with parents first !! (means already set in old)
		 *
		 */
		foreach ($data as $item) {
			$old[$item->id] = $index;
			$data[$index]->treeid = $index;
			$data[$index]->parent = $item->parentid;
			if ($data[$index]->parent != -1) {
				$data[$index]->parent = isset($old[$item->parentid]) ? $old[$item->parentid] : -2;
			}
			$data[$index]->wrapnum = 0;
			$index++;
		}

		/*
		 * 2ND LOOP : construct SEED
		 *
		 * - for all childrens : construct 1st level 'seed'[]
		 */
		foreach ($data as $item) {
			/*		IS CHILD			->			PARENT[SEED][] = CHILD INDEX				*/
			if ($item->parent >= 0) {
				$data[$item->parent]->seed[] = $item->treeid;
			}
		}

		foreach ($data as $item) {
			/*		IS NOT A CHILD		->			DATA[]				*/
			if ($item->parent == -1) {
				self::$_new[] = $item;
				if (isset($item->seed)) {
					self::getSeed($data, $item->seed);
				}
			}
		}

		return self::$_new;
	}
}