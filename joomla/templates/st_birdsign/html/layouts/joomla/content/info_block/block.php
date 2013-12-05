<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$blockPosition = $displayData['params']->get('info_block_position', 0);

?>

			<dl class="article-info  span8">
			<?php if ($displayData['params']->get('show_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
				<dd class="parent-category-name">
					<?php $title = $this->escape($displayData['item']->parent_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($displayData['item']->parent_slug)).'">'.$title.'</a>';?>
					<?php if ($displayData['params']->get('link_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
						<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
					<?php else : ?>
						<?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
					<?php endif; ?>
				</dd>
			<?php endif; ?>
			
			<?php if ($displayData['params']->get('show_category')) : ?>
				<dd class="category-name">
					<?php $title = $this->escape($displayData['item']->category_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($displayData['item']->catslug)).'">'.$title.'</a>';?>
					<?php if ($displayData['params']->get('link_category') && $displayData['item']->catslug) : ?>
						<?php echo $url; ?>
					<?php else : ?>
						<?php echo $title; ?>
					<?php endif; ?>
				</dd>
			<?php endif; ?>
			
			<?php if ($displayData['params']->get('show_create_date')) : ?>
				<dd class="create">
					<?php echo JHtml::_('date', $displayData['item']->created, JText::_('DATE_FORMAT_LC2')); ?>
				</dd>
			<?php endif; ?>
			
			<?php if ($displayData['params']->get('show_modify_date')) : ?>
				<dd class="modified">
					<?php echo JHtml::_('date', $displayData['item']->modified, JText::_('DATE_FORMAT_LC2')); ?>
				</dd>
			<?php endif; ?>
			
			<?php if ($displayData['params']->get('show_publish_date')) : ?>
				<dd class="published">
					<?php echo JHtml::_('date', $displayData['item']->publish_up, JText::_('DATE_FORMAT_LC2')); ?>
				</dd>
			<?php endif; ?>
			
			<?php if ($displayData['params']->get('show_author') && !empty($displayData['item']->author )) : ?>
				<dd class="createdby">
					<?php $author = $displayData['item']->author; ?>
					<?php $author = ($displayData['item']->created_by_alias ? $displayData['item']->created_by_alias : $author); ?>
					<?php if (!empty($displayData['item']->contactid ) && $displayData['params']->get('link_author') == true) : ?>
						<?php
						echo JText::sprintf('',
							JHtml::_('link', JRoute::_('index.php?option=com_contact&view=contact&id='.$displayData['item']->contactid), $author)
						); ?>
					<?php else :?>
						<?php echo  $author; ?>
					<?php endif; ?>
				</dd>
			<?php endif; ?>
			
			<?php if ($displayData['params']->get('show_hits')) : ?>
				<dd class="hits">
					<?php echo $displayData['item']->hits; ?>
				</dd>
			<?php endif; ?>
			</dl>
	
