<?php
/**
 * @author     Daniel Dimitrov - compojoom.com
 * @date: 15.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

JToolbarHelper::title('Create new config');

if (!version_compare(JVERSION, '3.0', 'gt'))
{
	JHtml::stylesheet('media/com_comment/backend/css/bootstrap.css');
	JHtml::stylesheet('media/com_comment/backend/css/strapper.css');
}

?>
<style type="text/css">
	.ccomment-group select {
		line-height: 28px;
	}
	.ccomment-group button.btn{
		vertical-align: top;
	}
</style>
<div class="compojoom-bootstrap">
	<div class="row-fluid">
		<p class="alert alert-info">
			<?php echo JText::sprintf('COM_COMMENT_REFER_TO_DOCUMENTATION_FOR_INTEGRATION', 'https://compojoom.com/support/documentation/compojoom_comment'); ?>
			<?php if(!CCOMMENT_PRO): ?>
				(<?php echo JText::_('COM_COMMENT_CORE_VERSION_NOT_ALL_PLUGINS'); ?>)
			<?php endif; ?>
		</p>
		<p>
			<?php echo JText::_('COM_COMMENT_SELECT_COMPONENT'); ?>
		</p>
	</div>
	<form id="adminForm" action="<?php echo JRoute::_('index.php?option=com_comment&task=settings.edit'); ?>"
	      method="post">

		<div class="control-group ccomment-group">
		<?php echo $this->plugins; ?>

			<button class="btn btn-primary"><?php echo JText::_('COM_COMMENT_NEXT'); ?></button>

		</div>

		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>