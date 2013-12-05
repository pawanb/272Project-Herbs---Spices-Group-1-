<?php
/**
 * NoNumber Framework Helper File: Assignments: Tags
 *
 * @package         NoNumber Framework
 * @version         13.11.21
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2013 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

/**
 * Assignments: Tags
 */
class NNFrameworkAssignmentsTags
{
	function passTags(&$parent, &$params, $selection = array(), $assignment = 'all', $article = 0)
	{
		$tags = array();

		$is_content = in_array($parent->params->option, array('com_content', 'com_flexicontent'));

		if ($is_content)
		{
			$is_category = in_array($parent->params->view, array('category'));
			$is_item = in_array($parent->params->view, array('', 'article', 'item'));

			if ($is_item)
			{
				if (!$article)
				{
					require_once JPATH_SITE . '/components/com_content/models/article.php';
					$model = JModelLegacy::getInstance('article', 'contentModel');
					$article = $model->getItem($parent->params->id);
				}
				if ($article && isset($article->metadata))
				{
					$mtags = $article->metadata->get('tags');
					if ($mtags)
					{
						$tags = array_merge($tags, $mtags);
					}
				}
			}
			else if ($is_category)
			{
				require_once JPATH_SITE . '/components/com_content/models/category.php';
				$model = JModelLegacy::getInstance('category', 'contentModel');
				$category = $model->getCategory();
				if ($category && isset($category->metadata))
				{
					$metadata = json_decode($category->metadata);
					if (isset($metadata->tags))
					{
						$tags = array_merge($tags, $metadata->tags);
					}
				}
			}
		}

		$pass = 0;
		if (!empty($tags))
		{
			foreach ($tags as $tag)
			{
				$pass = in_array($tag, $selection);
				if ($pass && $params->inc_children == 2)
				{
					$pass = 0;
				}
				else if (!$pass && $params->inc_children)
				{
					$parentids = self::getParentIds($parent, $tag);
					$parentids = array_diff($parentids, array('1'));
					foreach ($parentids as $id)
					{
						if (in_array($id, $selection))
						{
							$pass = 1;
							break;
						}
					}
					unset($parentids);
				}
			}
		}

		return $parent->pass($pass, $assignment);
	}

	function getParentIds(&$parent, $id = 0)
	{
		return $parent->getParentIds($id, 'tags');
	}
}
