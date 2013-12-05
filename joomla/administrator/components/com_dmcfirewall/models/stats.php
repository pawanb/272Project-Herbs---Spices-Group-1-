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
require_once JPATH_ADMINISTRATOR . '/components/com_dmcfirewall/version.php';

class DmcfirewallModelStats extends FOFModel {	
	public function getBlockAttempts() {
		$db = JFactory::getDBO();
		$query = "SELECT `attacks_prevented` FROM `#__dmcfirewall_stats`";
		$db->setQuery($query);
		$db->query();
		
		return number_format((int)$db->loadResult());
	}
	
	public function getSQLAttempts() {
		$db = JFactory::getDBO();
		$query = "SELECT `sql_attempts_prevented` FROM `#__dmcfirewall_stats`";
		$db->setQuery($query);
		$db->query();
		
		return number_format((int)$db->loadResult());
	}
	
	public function getLoginAttempts() {
		$db = JFactory::getDBO();
		$query = "SELECT `bad_login_attempts` FROM `#__dmcfirewall_stats`";
		$db->setQuery($query);
		$db->query();
		
		return number_format((int)$db->loadResult());
	}
	
	public function getBotAttempts() {
		$db = JFactory::getDBO();
		$query = "SELECT `bot_attempts_prevented` FROM `#__dmcfirewall_stats`";
		$db->setQuery($query);
		$db->query();
		
		return number_format((int)$db->loadResult());
	}
	
	public function getHackAttempts() {
		$db = JFactory::getDBO();
		$query = "SELECT `hack_attempts_prevented` FROM `#__dmcfirewall_stats`";
		$db->setQuery($query);
		$db->query();
		
		return number_format((int)$db->loadResult());
	}
	
	public function getGeneralStats($withoutStatsTitle=FALSE) {
		$attackTitle				= JText::_('ATTACK_SUMMARY');
		$statsTitle					= '';
		$badLoginAttempts			= '';
		$goProAd					= '';
		$displayWeekStatsButton		= '';
		$jedListing					= '';
		$badBotsUpgrade				= '';
		
		if ($withoutStatsTitle != TRUE) {
			$statsTitle = "<span class=\"heading textLeft\">$attackTitle</span>";
			$displayWeekStatsButton = '
			
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>

<div class="fb-like" data-href="http://www.facebook.com/DeanMarshallConsultancyLtd" data-send="false" data-layout="button_count" data-width="91" data-show-faces="false" data-font="arial"></div>

	<a href="https://twitter.com/DMConsultancy" class="twitter-follow-button" data-show-count="false">Follow @DMConsultancy</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
		

			<p class="content-go-right"><a href="index.php?option=com_dmcfirewall&view=weekstats&tmpl=component" class="modal btn btn-info" rel="{handler: \'iframe\', size: {x: 750, y: 445}}">' . JText::_('STATS_WEEK_STATS_BUTTON') . '</a></p>';
			
			$coreOrProText = ISPRO ? 'Pro' : 'Core';
			$coreOrProID = ISPRO ? 25051 : 23659;
			$jedListing = JText::sprintf('STATS_RATE_US_ON_JED', $coreOrProText, $coreOrProID);
			//core 23659
			//pro 25051
		}
		if (ISPRO) {
			$badLoginAttempts = $this->getLoginAttempts();
		}
		
		if (!ISPRO) {
			if (!$withoutStatsTitle) {
				$goProAd = JText::_('GO_PRO');
			}
			$badBotsUpgrade = '<a href="http://www.webdevelopmentconsultancy.com/subscribe/levels.html" target="_blank" class="btn btn-inverse btn-mini" style="float:right;margin-left:5px;">Upgrade today!</a> <a href="http://www.webdevelopmentconsultancy.com/joomla-extensions/dmc-firewall/getting-started/configuring-dmc-firewall.html#badBots" class="btn btn-danger btn-mini" target="_blank" style="float:right; margin-top:5px; clear:both;">Minimal protection!</a>';
			$badLoginAttempts = 'NA <a href="http://www.webdevelopmentconsultancy.com/subscribe/levels.html" target="_blank" class="btn btn-inverse btn-mini" style="float:right;">Upgrade today!</a>';
		}
		
		$table_view = <<<TABLE_VIEW
		$statsTitle
		<table class="firewall-summary">
			<tr>
				<td width="50%">Attacks Prevented</td>
				<td width="50%">{$this->getBlockAttempts()}</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Hack Attempts Blocked</td>
				<td>{$this->getHackAttempts()}</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;SQL Attempts Blocked</td>
				<td>{$this->getSQLAttempts()}</td>
			</tr>
			<tr>
				<td valign="top">&nbsp;&nbsp;&nbsp;Bots Blocked</td>
				<td>{$this->getBotAttempts()} $badBotsUpgrade</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Bad Login Attempts Blocked</td>
				<td>$badLoginAttempts</td>
			</tr>
		</table>
		$displayWeekStatsButton
		$goProAd
		$jedListing
TABLE_VIEW;

		return $table_view;
	}
}