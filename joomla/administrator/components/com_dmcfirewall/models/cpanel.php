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

class DmcfirewallModelCpanel extends FOFModel {
	public function hasAkeeba() {
		$db = JFactory::getDBO();
		$query = "SELECT * FROM `#__extensions` WHERE `element` = 'com_akeeba' AND `enabled` = 1";
		$db->setQuery($query);
		$db->query();
		$countAkeeba = $db->getNumRows();
		
		if (JFile::exists(JPATH_ADMINISTRATOR.'/components/com_akeeba/akeeba.xml') && $countAkeeba) {
		//<a href="#" id="changelog">Release notes</a>
//			return '<div class="icon"><a href="index.php?option=com_akeeba&view=backup&tmpl=component" class="modal" rel="{handler: \'iframe\', size: {x: 600, y: 450}}"><img src="../media/com_dmcfirewall/images/has-akeeba.png" /><span>' . JText::_('CPANEL_HAS_AKEEBA') . '</span></a></div>';
			return '<div class="icon"><a href="index.php?option=com_akeeba&view=backup&tmpl=component" id="test" class="modal" rel="{handler: \'iframe\', size: {x: 750, y: 500}}"><img src="../media/com_dmcfirewall/images/has-akeeba.png" /><span>' . JText::_('CPANEL_HAS_AKEEBA') . '</span></a></div>';
		}
	}
}