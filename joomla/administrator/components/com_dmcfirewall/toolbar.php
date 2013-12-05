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

class DmcfirewallToolbar extends FOFToolbar {
	/**
	 * Disable rendering a toolbar.
	 * 
	 * @return array
	 */
	protected function getMyViews() {
		return array();
	}
	
	public function onCpanelsBrowse() {
		JToolBarHelper::title(JText::_('COM_DMCFIREWALL') . ' &#187; ' . JText::_('COM_DMCFIREWALL_CONTROLPANEL'), 'dmcfirewall');
		JToolBarHelper::preferences('com_dmcfirewall', '500', '700');
		
		$this->_renderDefaultSubmenus('cpanel');
	}
	
	public function onLogsBrowse() {
		JToolBarHelper::title(JText::_('COM_DMCFIREWALL') . ' &#187; ' . JText::_('COM_DMCFIREWALL_LOGVIEW'), 'dmcfirewall');
		JToolBarHelper::custom( 'deleteEntry', 'delete.png', 'delete_f2.png', 'Delete Record', true );
		JToolBarHelper::preferences('com_dmcfirewall', '500', '700');
		JToolBarHelper::back('COM_DMCFIREWALL_CONTROLPANEL', 'index.php?option=com_dmcfirewall');
		
		$this->_renderDefaultSubmenus('log');
	}
	
	public function onConfigsBrowse() {
		JToolBarHelper::title(JText::_('COM_DMCFIREWALL') . ' &#187; ' . JText::_('COM_DMCFIREWALL_CONFIGURATION'), 'dmcfirewall');
		JToolBarHelper::preferences('com_dmcfirewall', '500', '700');
		JToolBarHelper::back('COM_DMCFIREWALL_CONTROLPANEL', 'index.php?option=com_dmcfirewall');
		
		$this->_renderDefaultSubmenus('config');
	}
	
	public function onHealthchecksBrowse() {
		JToolBarHelper::title(JText::_('COM_DMCFIREWALL') . ' &#187; ' . JText::_('COM_DMCFIREWALL_HEALTH_CHECK'), 'dmcfirewall');
		JToolBarHelper::preferences('com_dmcfirewall', '500', '700');
		JToolBarHelper::back('COM_DMCFIREWALL_CONTROLPANEL', 'index.php?option=com_dmcfirewall');
		
		$this->_renderDefaultSubmenus('healthcheck');
	}
	
	public function onWeekstatsBrowse() {
		JToolBarHelper::title(JText::_('COM_DMCFIREWALL') . ' &#187; ' . JText::_('COM_DMCFIREWALL_WEEKSTATS_TITLE'), 'dmcfirewall');
		JToolBarHelper::preferences('com_dmcfirewall', '500', '700');
		JToolBarHelper::back('COM_DMCFIREWALL_CONTROLPANEL', 'index.php?option=com_dmcfirewall');
	}
	
	public function onScheduledreportingsBrowse() {
		JToolBarHelper::title(JText::_('COM_DMCFIREWALL') . ' &#187; ' . JText::_('COM_DMCFIREWALL_SCHEDULED_REPORTING'), 'dmcfirewall');
		JToolBarHelper::preferences('com_dmcfirewall', '500', '700');
		JToolBarHelper::back('COM_DMCFIREWALL_CONTROLPANEL', 'index.php?option=com_dmcfirewall');
		
		//$this->_renderDefaultSubmenus('cpanel');
	}
	
	private function _renderDefaultSubmenus($active = '') {
		$submenus = array(
			'cpanel'		=>	'COM_DMCFIREWALL_CONTROLPANEL',
			'config'		=>	'COM_DMCFIREWALL_CONFIGURATION',
			'log'			=>	'COM_DMCFIREWALL_LOG',
			'healthcheck'	=>	'COM_DMCFIREWALL_HEALTH_CHECK'
		);
		
		foreach($submenus as $view => $key) {
			$link = JURI::base().'index.php?option='.$this->component.'&view='.$view;
			$this->appendLink(JText::_($key), $link, $view == $active);
		}
	}
}