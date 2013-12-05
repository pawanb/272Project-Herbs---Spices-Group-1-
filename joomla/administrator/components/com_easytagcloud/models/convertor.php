<?php
/*
 * Convert Tags
 *
 * @package		com_easytagcloud
 * @version		2.4
 * @author		Kee Huang
 * @copyright	Copyright (c) 2013 www.joomlatonight.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 */
// Get Joomla! framework

define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
$parts = explode( DS, dirname(__FILE__) );	

array_pop($parts);
array_pop($parts);
array_pop($parts);
array_pop($parts);
define( 'JPATH_BASE', implode( DS, $parts ) );
require_once ( JPATH_BASE . '/includes'.DS.'defines.php' );
require_once ( JPATH_BASE . '/includes'.DS.'framework.php' );
$mainframe = JFactory::getApplication('site');
$mainframe->initialise();
$version = new JVersion;
$v = $version->DEV_LEVEL;
if (JRequest::getVar('task') == 'convert') {	
	    
	    $db = JFactory::getDBO();		
		$query = "SELECT id,title FROM #__tags";
		$db->setQuery($query);	
		$results = $db->loadObjectList();
		$tags_exist = Array();
		$count = 0;
		foreach ($results as $result) {
		   $tags_exist[$result->id] = trim(strtolower($result->title));
		}		
		unset($result, $results);
		
		$query = "SELECT * FROM #__content";
		$db->setQuery($query);		
		$results = $db->loadAssocList();
        foreach ($results as $result) {
		    $table = JTable::getInstance('Content');		
		    $metakey = $result['metakey'];
			// if metakey is empty, continue
			if (empty($metakey)) {
			    continue;
		    }

			if ($v < 4)
			{
			//Only avalible for J3.1.1 or earlier 	
			// get tags 
			$registry = new JRegistry;
		    $registry->loadString($result['metadata']);	
	        $tags = $registry->get('tags');		
            
			} else 
			// 3.1.4 or later
			{
	        $tagshelper =  new JHelperTags;
			$tags_string = trim($tagshelper->getTagIds($result['id'], 'com_content.article'));
			$tags = empty($tags_string) ? Array() : explode(",", $tags_string);
            }
			
			

			$keywords = explode(",", $metakey);
			
			foreach ($keywords as $kw) {
			   // if keyword exist in tags_exist
	   
			   $kw = trim($kw);
			   $kw_f = strtolower($kw);

			   if (in_array($kw_f, $tags_exist)) {

			       $tmp = array_keys($tags_exist, $kw_f);
				   $kw_id = $tmp[0];
				   // if tags include the keyword, skip

				   if (in_array($kw_id, $tags)) {
					  continue;
				   } else {
				   // if tags not include the keyword, add keyword id to tags
				      $tags[] = $kw_id;   
					  $count++;
				   }
				  
			   } else {
			   // keyword not exist in tags_exist, we need to add the tag
				 $tags[] = '#new#'.$kw;		
			     $count++;	          
				 			  
			   }
			   		   
			   
			}
			
			if ($v < 4) 
			{
			//Only avalible for J3.1.1 or earlier 
			// change metadata
			$registry->set('tags', $tags);
		    $result['metadata'] = $registry->toString();				
            $table->bind($result);
		    @$table->store();		
							
		    } else  // 3.1.4 or later
			{

			$table->bind($result);		

            $tagshelper->typeAlias = 'com_content.article';

			$tagshelper->preStoreProcess($table, $tags);
			
			$tagshelper->postStoreProcess($table, $tags);
			}

		}
     echo "Converting done, ".$count." tag(s) converted";

			
}	

?>