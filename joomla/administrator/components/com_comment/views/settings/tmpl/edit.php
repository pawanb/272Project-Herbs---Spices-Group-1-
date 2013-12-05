<?php
/***************************************************************
 *  Copyright notice
 *
 *  Copyright 2013 Daniel Dimitrov. (http://compojoom.com)
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
JHtml::_('behavior.framework');
JHtml::_('behavior.tooltip');
$init = "window.addEvent('domready', function() {new settings({element: 'jform_template_template', component: '" . $this->item->component . "'})});";
$document = JFactory::getDocument();
$document->addScriptDeclaration($init);
$input = JFactory::getApplication()->input;
JToolbarHelper::title('Comment configuration for ' . $input->getCmd('component'));

JToolbarHelper::save('settings.save');
JToolbarHelper::apply('settings.apply');
JToolbarHelper::cancel('settings.cancel');

if (!version_compare(JVERSION, '3.0', 'gt')) {
	JHtml::stylesheet('media/com_comment/backend/css/bootstrap.css');
	JHtml::stylesheet('media/com_comment/backend/css/strapper.css');
}

JHtml::script('media/com_comment/backend/js/settings.js');
JHtml::stylesheet('media/com_comment/backend/css/settings.css');
?>
<?php if (!version_compare(JVERSION, '3.0', 'gt')) : ?>
	<?php
	JHtml::stylesheet('media/com_comment/backend/css/bootstrap.css');
	JHtml::stylesheet('media/com_comment/backend/css/strapper.css');
	?>
	<script type="text/javascript">
		window.addEvent('domready', function(){
			document.id('configTabs').addEvent('click:relay(li)', function(e) {
				e.stop();
				this.getParent('ul').getChildren('li').removeClass('active');
				this.addClass('active');

				$$('div.tab-content div').removeClass('active');
				this.getChildren('a')[0].get('href').replace('#','');
				document.id(this.getChildren('a')[0].get('href').replace('#','')).addClass('active');
			});

			$$('.radio.btn-group label').addClass('btn');
			$$('.compojoom-bootstrap')[0].addEvent('click:relay(.btn-group label:not(.active))', function(){
				var	input = document.id(this.get('for'));
				if (!input.get('checked')) {
					this.getParent('.btn-group').getElements("label")
						.removeClass('active')
						.removeClass('btn-success')
						.removeClass('btn-danger')
						.removeClass('btn-primary');
					if (input.get('value') == '') {
						this.addClass('active btn-primary');
					} else if (input.get('value') == 0) {
						this.addClass('active btn-danger');
					} else {
						this.addClass('active btn-success');
					}
					input.set('checked', true);
				}
			});
			$$('.btn-group input[checked=checked]').forEach(function(el){
				if (el.get('value') == '') {
					$$("label[for=" + el.get('id') + "]").addClass('active btn-primary');
				} else if (el.get('value') == 0) {
					$$("label[for=" + el.get('id') + "]").addClass('active btn-danger');
				} else {
					$$("label[for=" + el.get('id') + "]").addClass('active btn-success');
				}
			});
		});
	</script>
<?php endif; ?>
<div class="compojoom-bootstrap">
	<form action='index.php' method='POST' name='adminForm' id="adminForm" class="form-validate form-horizontal">
		<div class="row-fluid">
			<div class="pull-right">
			<label class="ccomment-note-label"><?php echo JText::_('COM_COMMENT_NOTE_LABEL'); ?>:</label>
			<input type="text" class="input-xlarge" name="note" placeholder="<?php echo JText::_('COM_COMMENT_NOTE_PLACEHOLDER'); ?>"
			       value="<?php echo $this->item->note; ?>" style="margin-bottom: 9px;"/>
			</div>
		</div>
		<ul id="configTabs" class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#general">
					<?php echo JText::_('TAB_GENERAL_PAGE'); ?></a></li>
			<li><a data-toggle="tab" href="#security"><?php echo JText::_('TAB_SECURITY'); ?></a></li>
			<li><a data-toggle="tab" href="#layout"><?php echo JText::_('TAB_LAYOUT'); ?></a></li>
			<li><a data-toggle="tab" href="#template"><?php echo JText::_('COM_COMMENT_TAB_TEMPLATE'); ?></a></li>
			<li><a data-toggle="tab" href="#integrations"><?php echo JText::_('COM_COMMENT_TAB_INTEGRATIONS'); ?></a>
			</li>
		</ul>
		<div class="tab-content">
			<?php $tabs = array('general', 'security', 'layout', 'template', 'integrations'); ?>
			<?php foreach($tabs as $key => $value) : ?>
				<div id="<?php echo $value; ?>" class="tab-pane <?php echo $key == 0 ? 'active' : ''; ?>">
					<?php if(!CCOMMENT_PRO) : ?>
						<span class="ccomment-pro">
							* <?php echo JText::sprintf('COM_COMMENT_PRO_NOTICE', 'https://compojoom.com/joomla-extensions/compojoomcomment'); ?>
						</span>
					<?php endif; ?>
					<?php require_once($value.'.php'); ?>
				</div>
			<?php endforeach; ?>
		</div>

		<input type="hidden" name="id" value="<?php echo $this->item->id > 0 ? $this->item->id : ''; ?>"/>
		<input type="hidden" name="component" value="<?php echo $this->item->component; ?>"/>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="option" value="com_comment"/>
		<?php echo JHtml::_('form.token');?>
	</form>
</div>