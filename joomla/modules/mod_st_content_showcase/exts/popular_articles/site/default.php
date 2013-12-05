<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

if ($params->get('source') == 'article') 
{
	require_once JPATH_SITE.'/components/com_content/helpers/route.php';
	JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');
	$category = $params->get('article_catid', array());
	
	if (!count($category)) return;
	
	$app	= JFactory::getApplication();
	$db		= JFactory::getDbo();
	$result = array();
	$query = $db->getQuery(true);
	$query->select('a.*');
	$query->from('#__content AS a');
	$query->select('c.title AS category_title, c.path AS category_route, c.access AS category_access, c.alias AS category_alias')
			->join('LEFT', '#__categories AS c ON c.id = a.catid');
	$query->where('state = 1');
	$query->where('catid in ('.implode(',', $params->get('article_catid', array())).')');
	$query->order('hits DESC');
	$query->limit((int) $params->get('count', 5));
	$db->setQuery($query);
	$items = $db->loadObjectList();
	
	//$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
	$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
	//$model->setState('filter.access', $access);

	$access = true;
	
	foreach ($items as &$item) 
	{
		$item->readmore = strlen(trim($item->fulltext));
		$item->slug = $item->id.':'.$item->alias;
		$item->catslug = $item->catid.':'.$item->category_alias;
		
		if ($access || in_array($item->access, $authorised))
		{
			// We know that user has the privilege to view the article
			$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
			$item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE');
		}
		else {
			$item->link = JRoute::_('index.php?option=com_users&view=login');
			$item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE_REGISTER');
		}

		$item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_articles_news.content');
		
		$images = json_decode($item->images);
		
		
		if (!isset($images->image_intro) || empty($images->image_intro)) {
			if ($params->get('auto_find_image')) {
				preg_match('/<img[^>]*src=["|\']([^"|\']+)[^>]*>/', $item->introtext, $matchs);
				if (count($matchs)) {
					if ($matchs[1]) {
						$images->image_intro = $matchs[1];
					}
				}
			}
		}
		
		$item->introtext = preg_replace('/<img[^>]*>/', '', $item->introtext);
		
		if (isset($images->image_intro) and !empty($images->image_intro)) {
			$item->image_intro = $images->image_intro;
			$item->image_intro_caption = $images->image_intro_caption;
			$item->image_intro_alt = $images->image_intro_alt;
			$item->image_large = $images->image_intro;
		}
	}

	$result['hits'] = $items;
	$query->order('publish_up DESC');
	$db->setQuery($query);
	$items = $db->loadObjectList();
	
	//	Retrieve Content
	$access = true;
	
	foreach ($items as &$item) 
	{
		$item->readmore = strlen(trim($item->fulltext));
		$item->slug = $item->id.':'.$item->alias;
		$item->catslug = $item->catid.':'.$item->category_alias;
		
		if ($access || in_array($item->access, $authorised))
		{
			// We know that user has the privilege to view the article
			$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
			$item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE');
		}
		else {
			$item->link = JRoute::_('index.php?option=com_users&view=login');
			$item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE_REGISTER');
		}

		$item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_articles_news.content');
		
		$images = json_decode($item->images);
		
		
		if (!isset($images->image_intro) || empty($images->image_intro)) {
			if ($params->get('auto_find_image')) {
				preg_match('/<img[^>]*src=["|\']([^"|\']+)[^>]*>/', $item->introtext, $matchs);
				if (count($matchs)) {
					if ($matchs[1]) {
						$images->image_intro = $matchs[1];
					}
				}
			}
		}
		
		$item->introtext = preg_replace('/<img[^>]*>/', '', $item->introtext);
		
		if (isset($images->image_intro) and !empty($images->image_intro)) {
			$item->image_intro = $images->image_intro;
			$item->image_intro_caption = $images->image_intro_caption;
			$item->image_intro_alt = $images->image_intro_alt;
			$item->image_large = $images->image_intro;
		}
	}

	$result['latest'] = $items;
	
	$html = '<div class="st-content-tabs"><ul class="nav nav-tabs">';
	$html .= '<li><a href="#popular" data-toggle="tab">Popular</a></li>';
	$html .= '<li><a href="#latest" data-toggle="tab">Latest</a></li>';
	$html .= '</ul>';
	
	$html .= '<div class="tab-content">';
	
		$html .= '<div class="tab-pane active" id="popular">';
		
		foreach ($result['hits'] as $item) 
		{
			$html .= '<div class="outter"><div class="row-fluid">';
			
				$html .= '<div class="span4">';
				$html .= '<a href="'.$item->link.'"><img src="'.$item->image_intro.'"/></a>';
				$html .= '</div>';
				
				$html .= '<div class="span8">';
				$html .= '<a href="'.$item->link.'">'.$item->title.'</a>';
				$html .= '</div>';
				
			$html .= '</div></div>';
		}
			
		$html .= '</div>';
	
		$html .= '<div class="tab-pane active" id="latest">';
		
		foreach ($result['latest'] as $item) 
		{
			$html .= '<div class="outter"><div class="row-fluid">';
			
				$html .= '<div class="span4">';
				$html .= '<a href="'.$item->link.'"><img src="'.$item->image_intro.'"/></a>';
				$html .= '</div>';
				
				$html .= '<div class="span8">';
				$html .= '<a href="'.$item->link.'">'.$item->title.'</a>';
				$html .= '</div>';
				
			$html .= '</div></div>';
		}
		
		$html .= '</div>';
	
	
	$html .= '</div></div>';
	
	echo $html;
	
	$document = JFactory::getDocument();
	$document->addScriptDeclaration("
	
		jQuery.noConflict();
		(function($){
			$(document).ready(function(){
				$('.st-content-tabs ul.nav li a:first').tab('show');	
			});
		})(jQuery);


	");
}
