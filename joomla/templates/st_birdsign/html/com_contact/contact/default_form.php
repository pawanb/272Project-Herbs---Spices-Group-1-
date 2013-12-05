<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<script type="text//javascript">
	JFormValidator.implement({
		handleResponse: function(state, el)
		{
			// Set the element and its label (if exists) invalid state
			if (state == false) {
				el.addClass('invalid');
				el.set('aria-invalid', 'true');
			} else {
				el.removeClass('invalid');
				el.set('aria-invalid', 'false');
			}
		}
	});
	document.formvalidator = null;
	window.addEvent('domready', function(){
		document.formvalidator = new JFormValidator();
	});
</script>

<div class="contact-form">
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate form-horizontal">
			<div class="row-fluid">
				<div class="span8">
					<?php echo $this->form->getInput('contact_name', null, JText::_('COM_CONTACT_CONTACT_EMAIL_NAME_LABEL', true)); ?>
					<?php echo $this->form->getInput('contact_email', null, JText::_('COM_CONTACT_EMAIL_LABEL', true)); ?>
				</div>
			</div>
			<div><?php echo $this->form->getInput('contact_subject', null, JText::_('COM_CONTACT_CONTACT_MESSAGE_SUBJECT_LABEL', true)); ?></div>
			<div><?php echo $this->form->getInput('contact_message', null, JText::_('COM_CONTACT_CONTACT_ENTER_MESSAGE_LABEL', true)); ?></div>

			<?php if ($this->params->get('show_email_copy')) { ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('contact_email_copy'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('contact_email_copy'); ?></div>
				</div>
			<?php } ?>
			<?php //Dynamically load any additional fields from plugins. ?>
			<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
				<?php if ($fieldset->name != 'contact'):?>
					<?php $fields = $this->form->getFieldset($fieldset->name);?>
					<?php foreach ($fields as $field) : ?>
							<?php if ($field->hidden) : ?>
									<?php echo $field->input;?>
							<?php else:?>
								<div>
									<?php echo $field->label; ?>
									<?php if (!$field->required && $field->type != "Spacer") : ?>
										<span class="optional"><?php echo JText::_('COM_CONTACT_OPTIONAL');?></span>
									<?php endif; ?>
									<?php echo $field->input;?></div>
							<?php endif;?>
					<?php endforeach;?>
				<?php endif ?>
			<?php endforeach;?>
			<div><button class="btn btn-primary validate" type="submit"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>
				<input type="hidden" name="option" value="com_contact" />
				<input type="hidden" name="task" value="contact.submit" />
				<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
				<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
	</form>
</div>
