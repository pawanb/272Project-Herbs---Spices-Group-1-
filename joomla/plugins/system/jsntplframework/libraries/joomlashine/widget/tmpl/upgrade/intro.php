<div id="jsn-upgrade-intro">
	<p><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_INTRO_DESC') ?></p>
	<div class="alert alert-warning">
		<span class="label label-important"><?php echo JText::_('JSN_TPLFW_IMPORTANT_INFORMATION') ?></span>
		<ul>
			<li><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_INTRO_NOTE_01') ?></li>
			<li><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_INTRO_NOTE_02') ?></li>
		</ul>
	</div>

	<?php if ($template['edition'] == 'FREE'): ?>
	<div id="jsn-standard-benefits">
		<h2><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_STANDARD_BENEFITS') ?></h2>
		<ul>
			<li><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_STANDARD_BENEFITS_01') ?></li>
			<li><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_STANDARD_BENEFITS_02') ?></li>
			<li><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_STANDARD_BENEFITS_03') ?></li>
			<li><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_STANDARD_BENEFITS_04') ?></li>
		</ul>
	</div>
	<?php endif ?>

	<div id="jsn-unlimited-benefits">
		<h2><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_UNLIMITED_BENEFITS') ?></h2>
		<ul>
			<li><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_UNLIMITED_BENEFITS_01') ?></li>
			<li><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_UNLIMITED_BENEFITS_02') ?></li>
			<li><?php echo JText::_('JSN_TPLFW_AUTO_UPGRADE_UNLIMITED_BENEFITS_03') ?></li>
		</ul>
	</div>

	<hr />
	<div class="jsn-actions">
		<?php $nextEdition = $template['edition'] == 'FREE' ? '' : 'UNLIMITED' ?>
		<?php $purchaseLink = 'http://www.joomlashine.com/joomla-templates/jsn-'.trim(substr($template['id'], 4)).'-download.html' ?>
		<p>
			<a href="javascript:void(0)" id="btn-start-upgrade" class="btn btn-primary"><?php echo JText::sprintf('JSN_TPLFW_AUTO_UPGRADE_ALREADY_PURCHASED', $nextEdition) ?></a>
		</p>
		<p>
			<a href="<?php echo $purchaseLink ?>" target="_blank" class="jsn-link-action"><?php echo JText::sprintf('JSN_TPLFW_AUTO_UPGRADE_PURCHASE_NOW', $nextEdition) ?></a>
		</p>
	</div>
</div>