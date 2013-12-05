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
	var $_extensionName			= 'com_comment';
	var $_versionStrategy		= 'different';

	public function __construct() {
		$this->_extensionTitle = 'CComment '.(CCOMMENT_PRO == 1 ? 'Professional' : 'Core');
		$this->_requiresAuthorization = (CCOMMENT_PRO == 1);
		$this->_currentVersion = CCOMMENT_VERSION;
		$this->_currentReleaseDate = CCOMMENT_DATE;

		if(CCOMMENT_PRO) {
			$this->_updateURL = 'https://compojoom.com/index.php?option=com_ars&view=update&format=ini&id=5';
		} else {
			$this->_updateURL = 'https://compojoom.com/index.php?option=com_ars&view=update&format=ini&id=16';
		}

		// populate downloadID as liveupdate cannot find the download id in the unknown for it scope
		$this->_downloadID = JComponentHelper::getParams('com_comment')->get('global.downloadid');

		parent::__construct();
	}
}