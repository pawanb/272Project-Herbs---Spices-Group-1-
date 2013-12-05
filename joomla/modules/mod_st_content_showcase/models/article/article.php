<?php
/**
 * @copyright	submit-templates.com
 * @license		GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

class stContentShowcaseModelArticle extends stContentShowcaseModel {
	
	public function  getCategories () 
	{
		$categories = $this->_params->get('article_catid', array());
		$items = array();
		
		if (implode(",",$categories)) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select("id, title")
			->from('#__categories')
			->where("id IN (".implode(",",$categories).")")
			->where("published = 1");
			$db->setQuery($query);
			$results = $db->loadObjectList();
			
			foreach ($results as $result) {
				$items[$result->id] = $result->title;
			}
		}
		
		return $items;
	}	public function _items() 
	{
		parent::_items();
		
		$app	= JFactory::getApplication();
		$db		= JFactory::getDbo();

		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		
		// Set application parameters in model
		$appParams = JFactory::getApplication()->getParams();
		$model->setState('params', $appParams);

		// Set the filters based on the module params
		$model->setState('list.start', 0);
		
		$model->setState('list.limit', (int) $this->_params->get('count', 5));

		$model->setState('filter.published', 1);

		$model->setState('list.select', 'a.fulltext, a.id, a.title, a.alias, a.introtext, a.state, a.catid, a.created, a.created_by, a.created_by_alias,' .
			' a.modified, a.modified_by, a.publish_up, a.publish_down, a.images, a.urls, a.attribs, a.metadata, a.metakey, a.metadesc, a.access,' .
			' a.hits, a.featured' );

		// Access filter
		//$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		//$model->setState('filter.access', $access);

		// Category filter
		
		$model->setState('filter.category_id', $this->_params->get('article_catid', array()));
		
		if ($this->_params->get('article_featured', 0)) {
			$model->setState('filter.featured', 'only');
		}
		
		// Filter by language
		$model->setState('filter.language', $app->getLanguageFilter());

		// Set ordering
		$ordering = $this->_params->get('article_ordering', 'a.publish_up');
		$model->setState('list.ordering', $ordering);
		if (trim($ordering) == 'rand()') {
			$model->setState('list.direction', '');
		} else {
			$model->setState('list.direction', 'DESC');
		}
		
		//	Retrieve Content
		$items = $model->getItems();
		
		$access = true;
		
		foreach ($items as &$item) 
		{
			$item->readmore = strlen(trim($item->fulltext));
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid.':'.$item->category_alias;
			$item->category = $item->category_title;
			
			if ($access || in_array($item->access, $authorised))
			{
				// We know that user has the privilege to view the article
				if ($this->_params->get('seo_link', 0)) 
				{
					$item->link = ContentHelperRoute::getArticleRoute($item->slug, $item->catslug);
					if ($this->_params->get('item_id', '') != '') {
						$item->link .= '&Itemid='.$this->_params->get('item_id', '');
					}
					
					$item->link = JRoute::_($item->link);
				} 
				else 
				{
					$item->link = JURI::base().'index.php?option=com_content&view=article&id='.$item->id;
					if ($this->_params->get('item_id', '') != '') {
						$item->link .= '&Itemid='.$this->_params->get('item_id', '');
					}	
				}
				
				$item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE');
			}
			else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
				$item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE_REGISTER');
			}

			$item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_articles_news.content');

			$images = json_decode($item->images);
			if ($images == null ) {
				$images = new stdClass;
			}
			if (!isset($images->image_intro) || empty($images->image_intro)) {
				if ($this->_params->get('auto_find_image')) {
					preg_match('/<img[^>]*src=["|\']([^"|\']+)[^>]*>/', $item->introtext, $matchs);
					if (count($matchs)) {
						if ($matchs[1]) {
							$images->image_intro = $matchs[1];
						}
					} else {
						preg_match('/<img[^>]*src=["|\']([^"|\']+)[^>]*>/', $item->fulltext, $matchs);
						if (count($matchs)) {
							if ($matchs[1]) {
								$images->image_intro = $matchs[1];
							}
						}
					}
				}
			}
			
			$item->introtext =  $item->introtext;
			
			if (isset($images->image_intro) and !empty($images->image_intro)) { 
				$item->image_intro = $images->image_intro;
				$item->image_intro_caption = $images->image_intro_caption;
				$item->image_intro_alt = $images->image_intro_alt;
				$item->image_large = $images->image_intro;
			}
		}
		return $items;
	}
}
