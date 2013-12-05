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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

JToolbarHelper::title('Edit Comment');
JtoolbarHelper::save('comment.save');
JtoolbarHelper::apply('comment.apply');
JToolbarHelper::cancel('comment.cancel');
if (!version_compare(JVERSION, '3.0', 'gt'))
{
	JHtml::stylesheet('media/com_comment/backend/css/bootstrap.css');
	JHtml::stylesheet('media/com_comment/backend/css/strapper.css');
}

?>

<script type="text/javascript">
	Joomla.submitbutton = function (task) {
		if (task == 'comment.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	}
</script>
<div class="compojoom-bootstrap">
	<form id="adminForm" name="adminForm" method="post"
	      action="<?php echo JRoute::_('index.php?option=com_comment&layout=edit&id=' . $this->item->id); ?>">
		<div class="row-fluid form-horizontal">
			<div class="control-group">
				<div class="control-label">
					<?php echo $this->form->getLabel('id') ?>
				</div>
				<div class="controls">
					<?php echo $this->item->id; ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $this->form->getLabel('comment') ?>
				<?php echo $this->form->getInput('comment'); ?>
			</div>
			<div class="span6">
				<div class="control-group">
					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('published') ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('published'); ?>
						</div>
					</div>
					<div class="control-label">
						<?php echo $this->form->getLabel('component') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('component'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('userid') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('userid'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('name') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('name'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('notify') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('notify'); ?>
					</div>
				</div>

				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('parentid') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('parentid'); ?>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('contentid') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('contentid'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('ip') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('ip'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('date') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('date'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('email') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('email'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('voting_yes') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('voting_yes'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('voting_no') ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('voting_no'); ?>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token');?>
	</form>
</div>