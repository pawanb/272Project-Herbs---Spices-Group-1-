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

require_once JPATH_COMPONENT_ADMINISTRATOR . '/version.php';
define('DMCFIREWALLNOCACHE', md5(DMCFIREWALL_VERSION.DMCFIREWALL_RELEASE_DATE));

class DmcfirewallDispatcher extends FOFDispatcher {

	public function onBeforeDispatch() {
		$result = parent::onBeforeDispatch();
		
		if($result) {
			// Load Akeeba Strapper
			include_once JPATH_ROOT.'/media/akeeba_strapper/strapper.php';
			AkeebaStrapper::$tag = DMCFIREWALLNOCACHE;
			AkeebaStrapper::bootstrap();
			AkeebaStrapper::jQueryUI();
			AkeebaStrapper::addJSfile('media://com_akeeba/js/gui-helpers.js');
			AkeebaStrapper::addJSfile('media://com_akeeba/js/akeebaui.js');
			AkeebaStrapper::addJSfile('media://com_akeeba/plugins/js/akeebaui.js');
			AkeebaStrapper::addCSSfile('media://com_akeeba/theme/akeebaui.css');
			
			jimport('joomla.version');
			$jVersion = new JVersion();

			JHtml::_('behavior.modal');

			if ($jVersion->RELEASE == '2.5') {
				JFactory::getDocument()->addStyleSheet(JURI::root() . 'media/com_dmcfirewall/css/admin-j25.css?=' . DMCFIREWALLNOCACHE);
			}
			JFactory::getDocument()->addStyleSheet(JURI::root() . 'media/com_dmcfirewall/css/admin.css?=' . DMCFIREWALLNOCACHE);
			
			if ($this->input->getCmd('view','') != 'weekstats') {
				JFactory::getDocument()->addScript(JURI::root() . 'media/com_dmcfirewall/js/firewall.js?v=' . DMCFIREWALLNOCACHE);
			}

		}
		
		return $result;
	}
	
	public function dispatch() {
		require_once JPATH_COMPONENT_ADMINISTRATOR.'/liveupdate/liveupdate.php';
		if(JRequest::getCmd('view','') == 'liveupdate') {
			LiveUpdate::handleRequest();
			return;
		}
		
		FOFInput::setVar('view', $this->view, $this->input);
		
		parent::dispatch();
	}
}