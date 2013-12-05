<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;
require_once JPATH_SITE.'/components/com_k2/helpers/route.php';

class stContentShowcaseModelK2 extends stContentShowcaseModel {
	
	public function  getCategories () 
	{
		$categories = $this->_params->get('k2_catid', array());
		$items = array();
		
		if (implode(",",$categories)) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select("id, name")
			->from('#__k2_categories')
			->where("id IN (".implode(",",$categories).")")
			->where("published = 1");
			$db->setQuery($query);
			$results = $db->loadObjectList();
			
			foreach ($results as $result) {
				$items[$result->id] = $result->name;
			}
		}
		
		return $items;
	}
	
	public function _items() 
	{
		parent::_items();
		
		jimport('joomla.filesystem.file');
		$mainframe = JFactory::getApplication();
		$limit = $this->_params->get('count', 5);
		$cid = $this->_params->get('k2_catid', array());
		
		if (!count($cid)) {
			return array();
		}
		
		$ordering = $this->_params->get('k2_itemsOrdering');

		$user = JFactory::getUser();
		$aid = $user->get('aid');
		
		$db = JFactory::getDBO();

		$jnow = JFactory::getDate();
		$now = $jnow->toSql();
		$nullDate = $db->getNullDate();
		
		$query = "SELECT i.*, CASE WHEN i.modified = 0 THEN i.created ELSE i.modified END as lastChanged, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams";

		if ($ordering == 'best')
			$query .= ", (r.rating_sum/r.rating_count) AS rating";

		if ($ordering == 'comments')
			$query .= ", COUNT(comments.id) AS numOfComments";

		$query .= " FROM #__k2_items as i LEFT JOIN #__k2_categories c ON c.id = i.catid";

		if ($ordering == 'best')
			$query .= " LEFT JOIN #__k2_rating r ON r.itemID = i.id";

		if ($ordering == 'comments')
			$query .= " LEFT JOIN #__k2_comments comments ON comments.itemID = i.id";

		$query .= " WHERE i.published = 1 AND i.access IN(".implode(',', $user->getAuthorisedViewLevels()).") AND i.trash = 0 AND c.published = 1 AND c.access IN(".implode(',', $user->getAuthorisedViewLevels()).") AND c.trash = 0";
		
		JArrayHelper::toInteger($cid);
		$query .= " AND i.catid IN(".implode(',', $cid).")";		

		$query .= " AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )";
		$query .= " AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )";

		if ($ordering == 'comments')
			$query .= " AND comments.published = 1";

		switch ($ordering)
		{
			case 'date' :
				$orderby = 'i.created ASC';
				break;
			case 'rdate' :
				$orderby = 'i.created DESC';
				break;
			case 'alpha' :
				$orderby = 'i.title';
				break;
			case 'ralpha' :
				$orderby = 'i.title DESC';
				break;
			case 'order' :
				$orderby = 'i.ordering';
				break;
			case 'rorder' :
				$orderby = 'i.ordering DESC';
				break;
			case 'hits' :
				$orderby = 'i.hits DESC';
				break;
			case 'rand' :
				$orderby = 'RAND()';
				break;
			case 'best' :
				$orderby = 'rating DESC';
				break;
			case 'comments' :
				$query .= " GROUP BY i.id ";
				$orderby = 'numOfComments DESC';
				break;
			case 'modified' :
				$orderby = 'lastChanged DESC';
				break;
			case 'publishUp' :
				$orderby = 'i.publish_up DESC';
				break;
			default :
				$orderby = 'i.id DESC';
				break;
		}

		$query .= " ORDER BY ".$orderby;
		$db->setQuery($query, 0, $limit);
		$items = $db->loadObjectList();
		
		foreach ($items as &$item) 
		{
			$date = JFactory::getDate($item->modified);
	        $timestamp = '?t='.$date->toUnix();
			$item->category = $item->categoryname;
			$item->link = K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->categoryalias));
			
			if ($this->_params->get('item_id', '') != '') {
		    	$item->link .= '&Itemid='.$this->_params->get('item_id', ''); 
		    }

			$item->link = urldecode(JRoute::_($item->link));
			
	        if (JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'k2'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.md5("Image".$item->id).'_'.$this->_params->get('k2_image_size').'.jpg'))
	        {
	        	$item->image = JURI::root().'media/k2/items/cache/'.md5("Image".$item->id).'_'.$this->_params->get('k2_image_size').'.jpg'.$timestamp;
				$item->image_intro = $item->image;
				$item->image_intro_caption = $item->title;
				$item->image_intro_alt = $item->title;
				$item->image_large = $item->link;
	        }
			
		}
		
		return $items;
	}
}
