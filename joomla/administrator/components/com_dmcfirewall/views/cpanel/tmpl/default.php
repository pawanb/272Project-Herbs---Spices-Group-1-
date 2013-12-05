<?php
/**
 * @Package			DMC Firewall
 * @Copyright		Dean Marshall Consultancy Ltd
 * @license			http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Email			software@deanmarshall.co.uk
 * web:				http://www.deanmarshall.co.uk/
 * web:				http://www.webdevelopmentconsultancy.com/
 */

defined('_JEXEC') or die('Direct access forbidden!');

/* Temp */
$app 								= JApplication::getInstance('site');//;JFactory::getApplication('admin');
$componentParams					= JComponentHelper::getParams('com_dmcfirewall');
$dlid								= $componentParams->get('dlid', ''); 
/* End of temp */

?>
<div id="cpanel" class="row-fluid">
	<div class="span8">
		<?php
		if (ISPRO && !$dlid) {
			echo '<div class="alert alert-danger"><h4 class="alert-heading">Warning</h4><p style="margin-top:15px;">' . JText::_('ENTER_DOWNLOAD_ID') . '</p></div>';
		}
		?>
		<h2><?php echo JText::_('COM_DMCFIREWALL') . ' ' . DMCFIREWALL . ' ' . JText::_('RELEASE'); ?></h2>
		<?php echo LiveUpdate::getIcon(); ?>
		
		<div class="icon">
			<a href="index.php?option=com_dmcfirewall&view=config">
				<img src="../media/com_dmcfirewall/images/config.png" />
				<span><?php echo JText::_('CPANEL_INTERNAL_CONFIG'); ?></span>
			</a>
		</div>
		
		<div class="icon">
			<a href="index.php?option=com_dmcfirewall&view=log">
				<img src="../media/com_dmcfirewall/images/log.png" />
				<span><?php echo JText::_('CPANEL_VIEW_ATTACK_LOG'); ?></span>
			</a>
		</div>
		
		<div class="icon">
			<?php if(version_compare(JVERSION, '3.0', 'lt')): ?>
			<a href="index.php?option=com_config&view=component&component=com_dmcfirewall&path=&tmpl=component"
				class="modal"
				rel="{handler: 'iframe', size: {x: 660, y: 500}}">
				<img src="../media/com_dmcfirewall/images/config-48-cog.png" />
				<span><?php echo JText::_('CPANEL_COMPONENT_CONFIG'); ?></span>
			</a>
			<?php else: ?>
			<a href="index.php?option=com_config&view=component&component=com_dmcfirewall&path=&return=<?php echo base64_encode(JURI::getInstance()->toString()); ?>">
				<img src="../media/com_dmcfirewall/images/config-48-cog.png" />
				<span><?php echo JText::_('CPANEL_COMPONENT_CONFIG'); ?></span>
			</a>
			<?php endif; ?>
		</div>
		
		<h2 style="clear:left;"><?php echo JText::_('OPERATIONS'); ?></h2>
		
		<?php echo $this->hasAkeeba; ?>
		
		<div class="icon">
			<a href="index.php?option=com_dmcfirewall&view=healthcheck">
				<img src="../media/com_dmcfirewall/images/healthcheck.png" />
				<span><?php echo JText::_('CPANEL_HEALTH_CHECK'); ?></span>
			</a>
		</div>
		
		<div class="icon">
			<a href="index.php?option=com_dmcfirewall&view=scheduledreporting">
				<img src="../media/com_dmcfirewall/images/graph.png" />
				<span><?php echo JText::_('CPANEL_SCHEDULED_REPORTING'); ?></span>
			</a>
		</div>
		
	</div>
	<div class="span4" style="float:right;">
	<!-- Right-hand issues -->
		<?php echo $this->firewallissues; ?>
	<!-- End of right-hand issues -->
	
	<!-- Right-hand stats -->	
		<?php echo $this->generalstats; ?>
	<!-- End of right-hand status -->
	</div>
	
	<div id="footer">
		<?php echo JText::_('FOOTER_COPYRIGHT'); ?>
		<?php echo JText::_('FOOTER_VERSION_TEXT') . ' ' . DMCFIREWALL_VERSION; ?><br />
		<?php echo JText::_('FOOTER_RELEASE_DATE_TEXT') . ' ' . DMCFIREWALL_RELEASE_DATE . ' ' . JTEXT::_('FOOTER_RELEASE_NOTES'); ?>
		<?php echo JText::_('FOOTER_DISCLAIMER_HEADER') . JTEXT::_('FOOTER_DISCLAIMER'); ?>
	</div>
	<?php // die(JPATH_COMPONENT_ADMINISTRATOR); ?>
	<div style="display:none;">
		<div id="firewall-changelog">
			<?php
			require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/coloriser.php';
			echo DmcfirewallChangelogColoriser::colorise(JPATH_COMPONENT_ADMINISTRATOR.'/CHANGELOG.php');
			?>
		</div>
	</div>
</div>