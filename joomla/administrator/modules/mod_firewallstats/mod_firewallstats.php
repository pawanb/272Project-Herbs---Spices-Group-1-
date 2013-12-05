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

$display = '';
JFactory::getDocument()->addStyleSheet(JURI::base() . 'modules/mod_firewallstats/css/mod.css?=' . time());

/*
 * Include the FOF library
 */
	if(!defined('FOF_INCLUDED')) {
		include_once JPATH_LIBRARIES . '/fof/include.php';
	}

/*
 * Load our language files to display human readable text
 */
	$lang = JFactory::getLanguage();
	$lang->load('com_dmcfirewall', JPATH_ADMINISTRATOR, 'en-GB', true);

/*
 * Load our configuration file so we can determine what to display
 */
	$componentParams = JComponentHelper::getParams('com_dmcfirewall');

/*
 * If the user has decided to hide 'known issues', there's no point in loading the files
 */
	if ($componentParams->get('displayIssues', 1)) {
		require_once JPATH_ADMINISTRATOR . '/components/com_dmcfirewall/models/issues.php';
		$model				= new DmcfirewallModelIssues();
		$display			.= $model->getIssues($withoutTitle=TRUE);
	}

/*
 * If the user has decided to hide 'attack stats', there's no point in loading the files
 */
	if ($componentParams->get('displayStats', 1)) {
		require_once JPATH_ADMINISTRATOR . '/components/com_dmcfirewall/models/stats.php';
		$statsModel			= new DmcfirewallModelStats();
		$display			.= $statsModel->getGeneralStats($withoutStatsTitle=TRUE);
	}

/*
 * If the user has decided to hide 'user icons', there's no point in loading the files
 */
	if ($componentParams->get('displayIcons', 1)) {
		require_once JPATH_ADMINISTRATOR . '/components/com_dmcfirewall/liveupdate/liveupdate.php';
		
		$liveUpdate = LiveUpdate::getIcon();
		$internalConfigText = JText::_('CPANEL_INTERNAL_CONFIG');
		$attackLogText = JText::_('CPANEL_VIEW_ATTACK_LOG');
		
		if (version_compare(JVERSION, '3.0', 'lt')) {
			$whatConfigButton = "<a href=\"index.php?option=com_config&view=component&component=com_dmcfirewall&path=&tmpl=component\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: 700, y: 500}}\"><img src=\"../media/com_dmcfirewall/images/config-48-cog.png\" /><span>" . JText::_('CPANEL_COMPONENT_CONFIG') . "</span></a>";
		}
		else {
			/*
			 * 'aHR0cDovL3d3dy53ZWJkZXZlbG9wbWVudGNvbnN1bHRhbmN5LmNvbS9hZG1pbmlzdHJhdG9yL2luZGV4LnBocD9vcHRpb249Y29tX2RtY2ZpcmV3YWxs'
			 * The string above is generated within Joomla 3.0 for the 'return' path for a component's Global Configuration
			 * base64_encode(JURI::getInstance()->toString())
			*/
			$whatConfigButton = "<a href=\"index.php?option=com_config&view=component&component=com_dmcfirewall&path=&return=aHR0cDovL3d3dy53ZWJkZXZlbG9wbWVudGNvbnN1bHRhbmN5LmNvbS9hZG1pbmlzdHJhdG9yL2luZGV4LnBocD9vcHRpb249Y29tX2RtY2ZpcmV3YWxs\"><img src=\"../media/com_dmcfirewall/images/config-48-cog.png\" /><span>" . JText::_('CPANEL_COMPONENT_CONFIG') . "</span></a>";
		}
		
		$display .=<<<DISPLAY_ICONS
		$liveUpdate<div class="icon">
	<a href="index.php?option=com_dmcfirewall&view=config">
		<img src="../media/com_dmcfirewall/images/config.png" />
		<span>$internalConfigText</span>
	</a>
</div><div class="icon">
	<a href="index.php?option=com_dmcfirewall&view=log">
		<img src="../media/com_dmcfirewall/images/log.png" />
		<span>$attackLogText</span>
	</a>
</div><div class="icon" style="margin-right:0;">$whatConfigButton</div>
DISPLAY_ICONS;
	}

echo $display;