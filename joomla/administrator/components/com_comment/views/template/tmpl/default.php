<?php
/**
 * @author Daniel Dimitrov - compojoom.com
 * @date: 15.02.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
 
defined('_JEXEC') or die('Restricted access');
?>

<div class="row-fluid">
	<?php $fieldsets = $this->form->getFieldsets('template_params'); ?>
	<?php foreach ($fieldsets as $key => $value) : ?>
		<div class="span6">
			<h3><?php echo JText::_($value->label); ?></h3>

			<?php $fields = $this->form->getFieldset($key); ?>

			<?php foreach ($fields as $field) : ?>
				<div class="control-group">
					<div class="control-label">
						<?php echo $field->label; ?>
					</div>
					<div class="controls">
						<?php echo $field->input; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
</div>