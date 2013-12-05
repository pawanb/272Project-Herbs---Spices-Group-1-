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

jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.environment.response' );

class plgSystemDmccontentsniffer extends JPlugin {
	public function __construct( &$subject, $config ) {
		parent::__construct( $subject, $config );
	}
	
	function onAfterRender($toArray = false){
		$siteApplication				= JApplication::getInstance('site');
		$app							= JFactory::getApplication();
		$componentParams 				= JComponentHelper::getParams('com_dmcfirewall');
		$testMode						= $componentParams->get('testmode', 0);
		$securityOutput					= $componentParams->get('securitynotice', 1);
		$thresholdLimit					= $componentParams->get('thresholdLimit', 5);
		
		if($app->isAdmin()) {
			return;
		}
 
		/* Get the contents of the page */
		$html							= JResponse::getBody();
		
		$snifferNeedles					= array('viagra', 'cialis', 'payday', 'loans', 'insurance');
		
		$snifferNeedles					= implode("|", $snifferNeedles);
		$snifferNeedles					= '/\b('.$snifferNeedles.')\b/i';
		
		// cycle through each of the haystacks
		$badContentCounter				= preg_match_all($snifferNeedles, $html, $matches);
		
		if ($badContentCounter >= $thresholdLimit) {
			$this->sendMail();
		}
		
		if ($testMode) {
			$messageOutput = '<div style="position:fixed; text-align:center; border:2px solid rgb(254, 123, 122); background-color:rgb(255, 214, 214); color:rgb(204, 0, 0); box-shadow:1px 1px 0px rgb(239, 246, 255) inset, -1px -1px 0px rgb(239, 246, 255) inset; text-shadow:1px 1px 0px rgb(239, 246, 255); top:0px; margin:0px auto 10px; width:100%; z-index:9999999;"><a target="_blank" href="http://www.webdevelopmentconsultancy.com/joomla-security-tools/dmc-firewall.html">DMC Firewall</a> is currently in \'Test Mode\'!<br>Please ensure that you re-enable DMC Firewall once you have finished testing!<span style="display: block; text-indent: -5555px; height: 0px;"><a target="_blank" href="http://www.webdevelopmentconsultancy.com/joomla-security-tools/dmc-firewall.html">DMC Firewall</a> is a <a href="http://www.webdevelopmentconsultancy.com/joomla-security.html" target="_blank">Joomla Security</a> extension!</span></div>';
			$html = preg_replace('/(<body[^>]*)(.*?)("[>])/is', '$1' . '>' . $messageOutput, $html);
		}

		if ($securityOutput != 2) {
			if ($securityOutput == 0) {
				$sOutput = " display:none;";
			}
			else {
				$sOutput = '';
			}
			$randomNotice = rand(1,2);

			$securityNotice = '<div style="font-size:11px; margin:5px auto 0; clear:both; text-align:center;' . $sOutput . '">';
			switch ($randomNotice) {
				case 1:
					$securityNotice .= 'Our website is protected by <a href="http://www.webdevelopmentconsultancy.com/joomla-security-tools/dmc-firewall.html" target="_blank">DMC Firewall!</a>';
				break;
				case 2:
					$securityNotice .= '<a href="http://www.webdevelopmentconsultancy.com/joomla-security-tools/dmc-firewall.html" target="_blank">DMC Firewall</a> is a <a href="http://www.webdevelopmentconsultancy.com/joomla-security.html" target="_blank">Joomla Security</a> extension!';
				break;
			}
			$securityNotice .= "</div>\n</body>";
			
			$html = preg_replace('@<\/body>@i', $securityNotice, $html, 1);
		}
		
		JResponse::setBody($html);
	}
	
	private function sendMail() {
	//get an instance of the getMailer()
		$mailer							=& JFactory::getMailer();
		$app							= JFactory::getApplication();
		$configSitename					= $app->getCfg('sitename');
		
		$configMailfrom					= $app->getCfg('mailfrom');
		$siteApplication				= JFactory::getApplication('site');
		$componentParams				= $siteApplication->getParams('com_dmcfirewall');
		$enableEmailsParam				= $componentParams->get('enableEmails', 2);
		$emailOverrideParam				= $componentParams->get('emailOverride', NULL);
		$emailAddress					= (!strstr($emailOverrideParam,"@")) || (!strstr($emailOverrideParam,".")) ?  $configMailfrom : $emailOverrideParam;
		
		
		$configDomain					= JURI::root();
		$currentURL						= JURI::current();
		$mailer->ClearAllRecipients();

	//build the parts of the email - sender, recipient, subject, email body
		$mailer->setSender(array($emailAddress, $configSitename));
		$mailer->addRecipient($emailAddress, $configSitename);//$recipient);
		$mailer->setSubject( 'DMC Firewall - Website Possibly Hacked!' );
		$body = $this->emailContent($configSitename, $configDomain, $currentURL);
		$mailer->isHTML(true);
		$mailer->setBody($body);
		$mailer->Send();
	}

	/*
	 * Build the email content
	 */
	private function emailContent($siteName, $domainPath, $requestedURL) {
		$theDate						= date('M d Y');
		$theTime						= date('H:i:s');
		$content = <<<EMAIL_CONTENT
			This is a security alert from the automated 'DMC Firewall Script' installed on your Joomla powered website:<br /><br />
			You are receiving this email as your 'Bad Content Threshold' has been exceeded!
			<table width="750px" style="margin-left:25px; margin-top:15px; margin-bottom:15px; border-collapse:collapse;">
				<tr>
					<td width="100px" style="border:1px solid #000;">Site Name</td>
					<td width="600px" style="border:1px solid #000;">{$siteName}</td>
				</tr>
				<tr>
					<td style="border:1px solid #000;">Date - Time</td>
					<td style="border:1px solid #000;">{$theDate} - {$theTime}</td>
				</tr>
				<tr>
					<td style="border:1px solid #000;">Domain</td>
					<td style="border:1px solid #000;">{$domainPath}</td>
				</tr>
				<tr>
					<td style="border:1px solid #000;">Requested URL</td>
					<td style="border:1px solid #000;">{$requestedURL}</td>
				</tr>
			</table>
		DMC Firewall is a Joomla Security extension by<br />
		Dean Marshall Consultancy Ltd<br />
		http://www.deanmarshall.co.uk/<br />
		http://www.webdevelopmentconsultancy.com/
EMAIL_CONTENT;
		
		return $content;
	}
}