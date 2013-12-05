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

class DmcfirewallGraphStatsHelper {
	public static function buildScheduledReport($reportDays) {
		$db = JFactory::getDBO();
		$buildArray = array();
		$currentDateMinus = date('Y-m-d', strtotime('-' . $reportDays . ' day', strtotime(date("Y-m-d"))));
		
		
		//This finds all of the attempts within the last x amount of days
		//We now need to loop round for the day specific values
		$query = "SELECT * FROM `#__dmcfirewall_log` WHERE `time_date` BETWEEN '" . $currentDateMinus . " - 00:00:00' AND '" . date('Y-m-d') . " - " . date('H:i:s') . "'";
		$db->setQuery($query);
		$db->query();
		
		foreach ($db->loadAssocList() as $entry) {
			$buildArray[substr($entry['time_date'], 0, 10)]['date'] = substr($entry['time_date'], 0, 10);
				
			switch($entry['reason']) {
				case 'Known Bad Bot':
					$buildArray[substr($entry['time_date'], 0, 10)]['badBots'] += 1;
				break;
				case 'SQL Injection Attempt':
					$buildArray[substr($entry['time_date'], 0, 10)]['sqlInjection'] += 1;
				break;
				case 'Hack Attempt':
					$buildArray[substr($entry['time_date'], 0, 10)]['hackInjection'] += 1;
				break;
				case 'Failed Login':
					$buildArray[substr($entry['time_date'], 0, 10)]['badLogins'] += 1;
				break;
			}
		}
		
		$dayRecords = '';
		$dayLoop = 0;
		$colour = 'style="background:#eeeeee"';
		foreach($buildArray as $day) {
			$addColour = ($dayLoop % 2) == 0 ? $colour : ''; 
			
			$dayRecords .= '<tr ' . $addColour . '><td style="border:1px solid #000;">';
			$dayRecords .= $day['date'] . ' - ' . date("l", strtotime($day['date']));
			$dayRecords .= '</td><td style="border:1px solid #000; text-align:right;">';
			$dayRecords .= $day['badBots'] == 0 ? 0 : $day['badBots'];
			$dayRecords .= '</td><td style="border:1px solid #000; text-align:right;">';
			$dayRecords .= $day['sqlInjection'] == 0 ? 0 : $day['sqlInjection'];
			$dayRecords .= '</td><td style="border:1px solid #000; text-align:right;">';
			$dayRecords .= $day['hackInjection'] == 0 ? 0 : $day['hackInjection'];
			$dayRecords .= '</td><td style="border:1px solid #000; text-align:right;">';
			$dayRecords .= $day['badLogins'] == 0 ? 0 : $day['badLogins'];
			$dayRecords .= '</td></tr>';
			
			$dayLoop++;
		}
		
		switch($reportDays) {
			case 1:
				$days = '24 hours';
			break;
			default:
				$days = $reportDays . ' days';
			break;
		}
		$emailBody =<<<EMAILBODY

<p>Here are the figures that relate to what DMC Firewall has banned from your website within the last $days!</p>
<table style="border-collapse:collapse;margin-left:20px">
	<thead>
		<tr>
			<th style="width:225px; border:1px solid #000;">Date</th>
			<th style="width:100px; border:1px solid #000;">Bad Bots</th>
			<th style="width:140px; border:1px solid #000;">SQL Injections</th>
			<th style="width:140px; border:1px solid #000;">Hack Attempts</th>
			<th style="width:100px; border:1px solid #000;">Bad Logins</th> 
		</tr>
	</thead>
	<tbody>
		$dayRecords
	</tbody>
</table>
<p>
	DMC Firewall is a script from<br />
	Dean Marshall Consultancy Ltd<br />
	http://www.deanmarshall.co.uk/<br />
	http://www.webdevelopmentconsultancy.com/
</p>
EMAILBODY;
		
		return $emailBody;
	}
}