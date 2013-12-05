<?php
/**
 * @version     $Id$
 * @package     JSNTPLFW
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Get template data
$data = JSNTplHelper::getEditingTemplate();

// Generate param name
$paramName =  (string) $this->element['name'];
?>
<div class="control-group<?php echo $this->value == 0 ? ' hide' : ''; ?>" id="<?php echo $this->id; ?>">
	<div class="control-label">
		<label rel="tipsy" for="jsn_sitetoolsColors" original-title="<?php echo JText::_('JSN_TPLFW_SITETOOLS_COLORS_DESC'); ?>">
			<?php echo JText::_('JSN_TPLFW_SITETOOLS_COLORS'); ?>
		</label>
	</div>
	<div class="controls">
		<div class="jsn-sortable-list jsn-color-list <?php echo $this->disabledClass ?>">
			<ul class="jsn-items-list ui-sortable" data-target="#<?php echo $this->id ?>_value">
				<?php foreach ($data->_JSNListColor->option['list'] as $item): ?>
				<?php $option = $data->_JSNListColor->default[$item] ?>
				<?php $checked = in_array($item, $data->_JSNListColor->option['checked']) ? 'checked' : '' ?>
				<li class="jsn-item ui-state-default">
					<label class="checkbox <?php echo $this->disabledClass ?>">
						<input type="checkbox" name="<?php echo $this->group ?>[sitetoolsColorsItems][]" value="<?php echo htmlentities($option['value']) ?>" <?php echo $checked ?> <?php echo $this->disabledClass ?> />
						<?php echo JText::_($option['label']) ?>
					</label>
				</li>
				<?php endforeach ?>
			</ul>
			<?php $value = is_array($data->params[$paramName]) ? json_encode($data->params[$paramName]) : $data->params[$paramName]; ?>
			<input type="hidden" name="<?php echo $this->name; ?>]" value="<?php echo htmlentities($value) ?>" id="<?php echo $this->id; ?>_value" />
		</div>
	</div>
</div>
<?php
if (isset($this->element['depends-on']))
{
?>
<script type="text/javascript">
	(function($) {
		var	element = $('#<?php echo $this->id; ?>'),
			depends_on = $('#<?php echo str_replace((string) $this->element['name'], (string) $this->element['depends-on'], $this->id); ?>'),
			toggle = function(state) {
				state ? element.removeClass('hide') : element.addClass('hide');
			};

		if (depends_on.length) {
			switch (depends_on[0].nodeName) {
				case 'SELECT':
					depends_on.change(function() {
						toggle(this.options[this.selectedIndex].value != '');
					}).trigger('change');
				break;

				case 'RADIO':
				case 'CHECKBOX':
					depends_on.click(function() {
						toggle(this.checked);
					}).trigger('click');
				break;
			}
		}
	})(jQuery);
</script>
<?php
}
