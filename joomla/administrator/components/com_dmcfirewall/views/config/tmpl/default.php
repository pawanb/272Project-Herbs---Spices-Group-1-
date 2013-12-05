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
?>
<div id="cpanel" class="row-fluid">
	<div class="span8">
		<h2><?php echo JText::_('COM_DMCFIREWALL') . ' ' . JText::_('COM_DMCFIREWALL_CONFIGURATION'); ?></h2>
		<?php
	// load the results of our checks that we performed within the model
		echo $this->serverfileoptions;
	// load the 'plg_dmcfirewall' plugin info
		echo $this->firewallPluginStatus;
	// load the 'plg_dmccontentsniffer' plugin info
		echo $this->snifferPluginStatus;
		?>
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
	<div style="display:none;">
		<div id="firewall-changelog">
			<?php
			require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/coloriser.php';
			echo DmcfirewallChangelogColoriser::colorise(JPATH_COMPONENT_ADMINISTRATOR . '/CHANGELOG.php');
			?>
		</div>
	</div>
</div>