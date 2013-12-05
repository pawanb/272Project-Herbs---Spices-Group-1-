<?php
/**
* @version      2.4
* @package		EasyTagCloud
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

class modTagcloudhelper 
{
 public function getTags($params) {
          global $mainframe;
          $db = JFactory :: getDBO();
		  $user = JFactory::getUser();
		  $groups = implode(',', $user->getAuthorisedViewLevels());
	      $document = JFactory::getDocument();	
          // jimport('cms.helper.tags');		  	   
          $tagcloud_params = new stdClass();
          $tagcloud_params->tagsarray = array();	
		  // add id and alias array for Joomla 3, the attributes may be combined in the future
          $tagcloud_params->tagsidarray = array();
          $tagcloud_params->tagsaliasarray = array();
		  		  		  
          $tagcloud_params->tagsstyle = array();
          $blacklist = '\''.str_replace(',', '\',\'', $params->get('blacklist')).'\'';  	
		    
		  $limit = $params->get('maxtags');
	      $query = $db->getQuery(true)
			 ->select(
				 array(
				   	'MAX(' . $db->quoteName('tag_id') . ') AS tag_id',
					' COUNT(*) AS count', 'MAX(t.title) AS title',
					'MAX(' .$db->quoteName('t.access') . ') AS access',
					'MAX(' .$db->quoteName('t.alias') . ') AS alias'
				 )
			 )
			 ->group($db->quoteName(array('tag_id', 'title', 'access', 'alias')))
			 ->from($db->quoteName('#__contentitem_tag_map'))
			 ->where($db->quoteName('t.access') . ' IN (' . $groups . ')');

		// Only return published tags
		$query->where($db->quoteName('t.published') . ' = 1 ');

        // blacklist
		if (!empty($blacklist)) {
		    $query->where($db->quoteName('t.title') . ' NOT IN (' . $blacklist .')');
	    }
		// Optionally filter on language
		$language = JComponentHelper::getParams('com_tags')->get('tag_list_language_filter', 'all');

		if ($language != 'all')
		{
			if ($language == 'current_language')
			{
				$language = JHelperContent::getCurrentLanguage();
			}
			$query->where($db->quoteName('t.language') . ' IN (' . $db->quote($language) . ', ' . $db->quote('*') . ')');
		}
	
		 $query->join('INNER', $db->quoteName('#__tags', 't') . ' ON ' . $db->quoteName('tag_id') . ' = t.id')
			->order('count DESC');

		 $db->setQuery($query, 0, $limit);
				  	 
		 // echo  $query->__toString(); 
          $results = $db->loadObjectlist();
		  $filteredarray = Array();
		  $i = 0;			  
		  
		  foreach ($results as $result) {
		    $filteredarray[$i] = new stdClass();
			$filteredarray[$i]->tag = $result->title;
			$filteredarray[$i]->freq = $result->count;
			$filteredarray[$i]->tagid = $result->tag_id;
			$filteredarray[$i]->tagalias = $result->alias;						
			$i++;
		  }

		 unset($i);	 
         // set the tags order. From v2.3,bug fixed in Nov.18,2012
         switch($params->get('tags_order')) {
                case 0:
		        $sortresult = self::tagSort($filteredarray, 0);
		        break;
		        case 1:
		        $sortresult = self::tagSort($filteredarray, 1);
		        break;
		        case 2:
		        $sortresult = self::tagSort($filteredarray, 2);
		        break;
		        case 3:
		        $sortresult = self::tagSort($filteredarray, 3);		 
         } 
		 
		 
		 
         foreach ($sortresult as $a) {
            $tagcloud_params->tagsarray[$a->tag] = $a->freq;	
			$tagcloud_params->tagsidarray[$a->tag] = $a->tagid;
			$tagcloud_params->tagsaliasarray[$a->tag] = $a->tagalias;				        
            
         }
         $tagcloud_params->notag = empty($tagcloud_params->tagsarray) ? true : false;	// v2.4.3	 
		 
		 // intelligent mode from v2.4 PRO
		 $tagcloud_params->intelmode = $params->get('intelmode');
		 
         $min_freq = $tagcloud_params->notag ? 0 : min($tagcloud_params->tagsarray);
		 $max_freq = $tagcloud_params->notag ? 0 : max($tagcloud_params->tagsarray);		 
	     $spread = $max_freq - $min_freq;	 

	     if ( $spread <= 0 )
	          $spread = 1;
	     $font_spread = $params->get('maxfontsize') - $params->get('minfontsize');
	     if ( $font_spread < 0 )
	          $font_spread = 1;
	     $font_step = $font_spread / $spread;		 
		 foreach( $sortresult as $result ) {  
	        $tagcloud_params->tagsstyle[$result->tag] = (int)($params->get('minfontsize') + (($result->freq - $min_freq) * $font_step));   // algorithmn change from v2.4
         }
	    
									

	     $color = 'color';
		 $hovercolor = 'hovercolor';
		 $bgcolor = 'bgcolor';
		 $hoverbgcolor = 'hoverbgcolor';
	     $tagcloud_params->$color = self::colorBuilder('tagscolor', true, $params);	
	     $tagcloud_params->$hovercolor = self::colorBuilder('tagshovercolor', true, $params);	
	     $tagcloud_params->$bgcolor = self::colorBuilder('tagsbgcolor', false, $params);
	     $tagcloud_params->$hoverbgcolor = self::colorBuilder('tagshoverbgcolor', false, $params);
		
		// bold tags
		$tagcloud_params->bold = $params->get('bold') ? "font-weight: bold;" : "";
	  
	    // tags underline
	    if( $params->get('show_underline') ) {
            $tagcloud_params->show_underline = "text-decoration: underline;";
	    } else {
            $tagcloud_params->show_underline = "text-decoration: none;";
		}
		 
	    // tags hover underline
	    if( $params->get('hover_show_underline') ) {
            $tagcloud_params->hover_show_underline = "text-decoration: underline;";
	    } else {
            $tagcloud_params->hover_show_underline = "text-decoration: none;";
		}

	    // tags align
	    switch( $params->get('tags_align') ) {
		  case 0:
		  $tagcloud_params->align = "left";
		  break;
		  case 1:
		  $tagcloud_params->align = "justify";
		  break;
		  case 2:
		  $tagcloud_params->align = "right";
		  break;
		  default:
		  $tagcloud_params->align = "center";
		} 	 
		 
	    // line height
	    $tagcloud_params->lineheight = $params->get('line_height').'px';
	
        // margin
	    $tagcloud_params->margin = ($params->get('horizontal_space') - 2).'px';
		
		// padding
		$tagcloud_params->padding = $params->get('tagspadding').'px';
		
		// border radius
		$tagcloud_params->borderradius = $params->get('borderradius').'px';
		
	    // search window
	    $tagcloud_params->searchwindow = $params->get('searchwindow') == 0 ? "_blank" : "_self";
	
	    // set colorful tags
	    $tagcloud_params->colorfultags = $params->get('colorful_tags');
		
		// google fonts v.2.4.3
        if ($params->get('googlefont') != '') {
		    $family = JString::str_ireplace(' ', '+', JString::trim($params->get('googlefont')));
		    $subset = $params->get('scriptsubset') == '' ? '' : '&subset='.$params->get('scriptsubset');
			$effect = $params->get('googlefonteffect') == '' ? '' : '&effect='.JString::substr($params->get('googlefonteffect'), 12);
		    $document->addStyleSheet('http://fonts.googleapis.com/css?family='.$family.$subset.$effect);
			$tagcloud_params->googlefont = "font-family: ".$params->get('googlefont').", serif;";
			$tagcloud_params->googlefont3d = 'textFont: "'.$params->get('googlefont').', serif"';
			$tagcloud_params->googlefonteffect = $params->get('googlefonteffect') == '' ? '' : 'class="'.$params->get('googlefonteffect').'"';
	    } else {
			$tagcloud_params->googlefont = $tagcloud_params->googlefont3d = $tagcloud_params->googlefonteffect = "";		
		}
																	
        return $tagcloud_params;
 }

 public function tagSort($result, $type) {
           $sort_array = Array();
	       $sort_array2 = Array();
	       $sort_array3 = Array();	
	       $merge_array = Array();
	       if($type == 1) {
	          return $result; //no need to sort
	       }else {
              foreach($result as $r) {
	             $sort_array[] = $r->tag;
	             $sort_array2[] = $r->tag;		
			     $sort_array3[] = $r->freq;	
		      }			      
	       }	      	
	      if($type == 0) {  //sort by tag name
		     natcasesort($sort_array);
	         foreach($sort_array as $i=>$a) {    
               $merge_array[] = $result[$i];
	         }			   
	       }
	       elseif($type == 2) { //sort by freq asc
		       natcasesort($sort_array3);
	           foreach($sort_array3 as $i=>$a) {
		       $merge_array[] = $result[$i];
	           }		
	       }
	       elseif($type == 3) { //sort randomly
		       shuffle($sort_array2);
	           foreach($sort_array2 as $a) {
	           $key = array_keys($sort_array, $a);
		       $merge_array[] = $result[$key[0]];
	           }		  
	       }
	      return $merge_array;
       }

 /**
  * added from v2.4 
  * @params string $name param name
  * @params boolean $type true for color,false for bgcolor 
  * @params $params
  */
 public function colorBuilder($name, $type, $params) {
            $colorprefix = $type ? "color: " : "background-color: ";
	        if( $params->get($name) == '' ) {
	            return "";
	        } else {	  		
	            return $colorprefix.$params->get($name).";";
            }            
          
 }

}
?>
