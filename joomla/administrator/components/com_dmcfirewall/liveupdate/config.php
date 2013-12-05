<?php
/**
 * @package LiveUpdate
 * @copyright Copyright ©2011 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU LGPLv3 or later <http://www.gnu.org/copyleft/lesser.html>
 */

defined('_JEXEC') or die();

/**
 * Configuration class for your extension's updates. Override to your liking.
 */
class LiveUpdateConfig extends LiveUpdateAbstractConfig
{
	var $_extensionName						= 'com_dmcfirewall';
	var $_versionStrategy					= 'different';
	
	function __construct()
	{
		require_once JPATH_ADMINISTRATOR . '/components/com_dmcfirewall/version.php';
		$this->_cacerts 					= dirname(__FILE__) . '/../assets/cacert.pem';
		$componentParams					= JComponentHelper::getParams('com_dmcfirewall');
		$dlid								= $componentParams->get('dlid', ''); 
		
		if (!ISPRO) {
			$this->_updateURL				= 'http://www.dmc-svn.com/downloads/fw/firewall.ini';
		}
		else {
			$this->_updateURL				= 'http://www.dmc-svn.com/downloads/fw/firewallpro.ini';
		}
		
		$this->_extensionTitle = 'DMC Firewall ' . (ISPRO == 1 ? 'Professional' : 'Core');
		$this->_requiresAuthorization = (ISPRO == 1);
		
		parent::__construct();
		
		$this->_downloadID = $dlid;
		
	}
}