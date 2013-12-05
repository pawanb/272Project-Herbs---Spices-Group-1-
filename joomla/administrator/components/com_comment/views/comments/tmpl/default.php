<?php
/***************************************************************
 *  Copyright notice
 *
 *  Copyright 2009 Daniel Dimitrov. (http://compojoom.com)
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

defined('_JEXEC') or die('Restricted access');
JToolbarHelper::title('Manage Comments');
JtoolbarHelper::publish('comments.publish');
JtoolbarHelper::unpublish('comments.unpublish');
JtoolbarHelper::editList('comment.edit');
JToolbarHelper::deleteList('COM_COMMENT_DELETE_COMMENTS', 'comments.delete');
// add the JavaScript for the tooltip
JHtml::_('behavior.tooltip');
JHtml::stylesheet('media/com_comment/backend/css/bootstrap.css');
JHtml::stylesheet('media/com_comment/backend/css/settings.css');
if (!version_compare(JVERSION, '3.0', 'gt')) {
	JHtml::stylesheet('media/com_comment/backend/css/bootstrap.css');
	JHtml::stylesheet('media/com_comment/backend/css/strapper.css');
}
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$selectedComponent = $this->escape($this->state->get('filter.component'));

?>
<div class="compojoom-bootstrap">
	<form action="" method="post" name="adminForm" id="adminForm">
		<table class="table">
			<tr>
				<td width="100%">
					<?php echo JText::_('JSEARCH_FILTER'); ?>:
					<input type="text" name="filter_search" id="filter_search"
					       placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>"
					       value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
					       class="text_area search-query"
					       onchange="document.adminForm.submit();"/>
					<button onclick="this.form.submit();" class="btn">
						<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
					</button>
					<button class="btn" onclick="document.getElementById('filter_search').value='';
											this.form.getElementById('filter_published').value='*';
											this.form.getElementById('component').value='';
											this.form.submit();">
						<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
					</button>
				</td>
				<td nowrap="nowrap">
					<?php echo JHtml::_('select.genericlist', $this->componentList, 'component', 'class="inputbox"
						onchange="submitform();"', 'value', 'text', $selectedComponent); ?>
					<select id="filter_published" name="filter_published" class="inputbox"
					        onchange="this.form.submit();">
						<?php echo JHtml::_('select.options',
							JHtml::_('jgrid.publishedOptions', array('trash' => false, 'archived' => false)),
							'value', 'text', $this->state->get('filter.published'), true); ?>
					</select>
				</td>

			</tr>
		</table>
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="table table-striped">
			<thead>
			<tr>
				<th width="2%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);"/>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_writer', 'name', $listDirn, $listOrder); ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_userid', 'userid', $listDirn, $listOrder); ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_notify', 'notify', $listDirn, $listOrder); ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_date', 'date', $listDirn, $listOrder); ?>
				</th>
				<th class="title" nowrap="nowrap" width="20%">
					<?php echo JHtml::_('grid.sort', 'COM_COMMENT_COMMENT_TITLE_TH', 'comment', $listDirn, $listOrder, 0, null, 'COM_COMMENT_COMMENT_TITLE_TH_DESC'); ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_contentitem', 'contentid', $listDirn, $listOrder); ?>
				</th>
				<th class="title" nowrap="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_COMMENT_COMMENT_COMPONENT_TH', 'comment', $listDirn, $listOrder, 0, null, 'COM_COMMENT_COMMENT_TITLE_TH_DESC'); ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_published', 'published', $listDirn, $listOrder); ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_delete', 'delete', $listDirn, $listOrder); ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_ip', 'delete', $listDirn, $listOrder); ?>
				</th>
				<th class="title">
					<?php echo JText::_('COM_COMMENT_VOTES') ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_parentid', 'parentid', $listDirn, $listOrder); ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_importtable', 'importtable', $listDirn, $listOrder); ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'viewcom_id', 'id', $listDirn, $listOrder); ?>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php
			for ($i = 0, $n = count($this->comments); $i < $n; $i++) :
				$comment = $this->comments[$i];

				?>
				<tr class="row<?php echo $i % 2; ?>">
					<td>
						<?php echo $comment->checked; ?>
					</td>

					<td align="center">
						<a href="<?php echo $comment->link_edit; ?>"><?php echo  $this->escape($comment->name); ?></a>
					</td>
					<td align="center">
						<?php echo $comment->userid; ?>
					</td>
					<td align="center">
						<?php echo $comment->notify; ?>
					</td>
					<td align="center">
						<?php echo $comment->date; ?>
					</td>
					<td>
						<?php echo $this->escape($comment->comment); ?>
					</td>
					<td align="center">
						<a href="<?php echo $comment->link ?>" target="_blank">
							<?php if (isset($this->titles[$comment->component][$comment->contentid])) : ?>
								<?php echo JString::substr($this->titles[$comment->component][$comment->contentid]->title, 0, 25); ?>
								<?php if (JString::strlen($this->titles[$comment->component][$comment->contentid]->title) > 40) : ?>
									...
								<?php endif; ?>
							<?php else: ?>
								<?php echo JText::_('COM_COMMENT_ITEM_NO_TITLE'); ?>
							<?php endif; ?>
						</a>
					</td>
					<td>
						<?php echo $comment->component; ?>
					</td>
					<td align="center">
				<span class="hasTip" title="<?php echo JText::_('NOTIFYPUBLISH'); ?>">
					<?php echo $comment->published ?>
				</span>
					</td>
					<td align="center">
				<span class="hasTip" title="<?php echo JText::_('NOTIFYREMOVE'); ?>">
					<?php echo $comment->delete; ?>
				</span>
					</td>
					<td align="center"><?php echo $comment->ip; ?></td>
					<td align="center">
						<div class="pull-left">
							<?php echo JText::_('JYES') ?>: <?php echo $comment->voting_yes; ?><br/>
							<?php echo JText::_('JNO') ?>: <?php echo $comment->voting_no; ?><br/>
						</div>
						<div class="pull-right">
							<?php echo JText::_('COM_COMMENT_TOTAL') ?>
							:  <?php echo $comment->voting_yes - $comment->voting_no; ?>
						</div>
					</td>
					<td align="center"><?php echo $comment->parentid; ?></td>
					<td align="center"><?php echo $comment->importtable; ?></td>
					<td align="center"><?php echo $comment->id; ?></td>
				</tr>
			<?php
			endfor;
			if (!count($this->comments)) :
				?>
				<tr>
					<td colspan="16">
						<?php echo JText::_('No comments'); ?>
					</td>
				</tr>
			<?php endif; ?>
			<tr>
				<td colspan="16">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
			</tbody>
		</table>
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
		<input type="hidden" name="boxchecked" value="0"/>
		<input type="hidden" name="option" value="com_comment"/>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="controller" value="comments"/>
		<input type="hidden" name="view" value="comments"/>
		<input type="hidden" name="confirm_notify" value=""/>
		<?php echo JHtml::_('form.token');?>
	</form>
</div>