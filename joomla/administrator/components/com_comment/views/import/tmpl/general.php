<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 12.03.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title('Import comments');
JHtml::_('behavior.framework');

$table = JFactory::getApplication()->input->getCmd('table');
?>

general
<p><?php echo JText::_('COM_COMMENT_IMPORT_COMMENT_MAPPING'); ?></p>
<script type="text/javascript">
	window.addEvent('domready', function() {
		document.id('table').addEvent('change', function(){
			submitform('import.from');
		});
	});
</script>
<form method="post" action="<?php echo JRoute::_('index.php?option=com_comment'); ?>" id="adminForm" name="adminForm">
	<table class="table table-striped">
		<tr>
			<td>Import from</td>
			<td><?php echo JHtml::_('select.genericlist', $this->tables, 'table', null, 'value', 'text', $table) ?></td>
			<td>Select the <b>database table
					which contains the comments to import</b></td>
		</tr>
		<tr>
			<td>Commented component value (required)</td>
			<td><?php echo JHtml::_('select.genericlist', $this->components, 'component') ?></td>
			<td>Select the column which contains the
				<b>Component name selection</b>.</td>
		</tr>
		<tr>
			<td>Component field</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[componentfield]') ?></td>
			<td>Select the column which contains the
				<b>Component name selection</b>.</td>
		</tr>
		<tr>
			<td>Id</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[id]') ?></td>
			<td>Select the column which contains the
				<b>Comment Id</b>.</td>
		</tr>
		<tr>
			<td>Contentid</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[contentid]') ?></td>
			<td>Select the column which contains the
				<b>Content Item Id</b</td>
		</tr>
		<tr>
			<td>Date</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[date]') ?></td>
			<td>Select the column which contains the
				<b>Date of the comment</b></td>
		</tr>
		<tr>
			<td>Name</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[name]') ?></td>
			<td>Select the column which contains the
				<b>Name</b> of the comment writer</td>
		</tr>
		<tr>
			<td>Userid</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[userid]') ?></td>
			<td>Select the column which contains the
				<b>Userid</b> of the comment writer</td>
		</tr>
		<tr>
			<td>IP</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[ip]') ?></td>
			<td>'Select the column which contains the
				<b>IP</b> of the comment writer</td>
		</tr>
		<tr>
			<td>Email</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[email]') ?></td>
			<td>Select the column which contains the
				<b>Email</b> of the comment writer</td>
		</tr>
		<tr>
			<td>Notify</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[notify]') ?></td>
			<td>Select the column which contains the
				<b>Notify parameter</b> of the comment writer (notify if new post paramter)</td>
		</tr>
		<tr>
			<td>Comment</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[comment]') ?></td>
			<td>Select the column which contains the
				<b>Text</b> of the comment</td>
		</tr>
		<tr>
			<td>Voting yes</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[voting_yes]') ?></td>
			<td>Select the column which contains the
				<b>voting_yes</b> of the comment</td>
		</tr>
		<tr>
			<td>Voting no</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[voting_no]') ?></td>
			<td>Select the column which contains the
				<b>voting_no</b> of the comment</td>
		</tr>
		<tr>
			<td>Published</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[published]') ?></td>
			<td>Select the column which contains the
				<b>Published parameter</b> of the comment</td>
		</tr>
		<tr>
			<td>Parent id</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[parentid]') ?></td>
			<td>Select the column which contains the
				<b>Parent Id</b> of the comment (when comment is linked as a child -- response -- of another comment)</td>
		</tr>
		<tr>
			<td>Modified date</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[modified]') ?></td>
			<td>Select the column which contains the
				<b>Published parameter</b> of the comment</td>
		</tr>
		<tr>
			<td>Modified by</td>
			<td><?php echo JHtml::_('select.genericlist', $this->columns, 'data[modified_by]') ?></td>
			<td>Select the column which contains the
				<b>Published parameter</b> of the comment</td>
		</tr>


	</table>
	<button class="btn btn-primary">Import</button>
	<input type="hidden" name="task" value="import.import" />
	<input type="hidden" name="import" value="general" />
	<?php echo JHtml::_( 'form.token' );?>
</form>