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
jimport( 'joomla.filesystem.file' );

class plgSystemDmcfirewall extends JPlugin {
	public function __construct( &$subject, $config ) {
		parent::__construct( $subject, $config );
	}

	function onAfterInitialise() {
	/*
	 * DMC Firewall - Variables
	 */
		$app							= JFactory::getApplication();
		$ipAddress						= trim($_SERVER['REMOTE_ADDR']);
		$queryString					= $_SERVER['QUERY_STRING'];
		$userAgent						= $_SERVER['HTTP_USER_AGENT'];
		$requestURI						= $_SERVER['REQUEST_URI'];
		$dmcfirewallactivate			= false;
		$componentParams 				= JComponentHelper::getParams('com_dmcfirewall');
		$lookUpResult 					= gethostbyaddr($ipAddress);
		$goodBots						= array('google', 'msn', 'yahoo');
		
		$testMode						= $componentParams->get('testmode', 0);
		
		if($app->isAdmin()) {
			return;
		}
		
	// cycle through all of the 'Good Bots' and turn them into individual entries
		foreach ($goodBots as $goodBot) {
			$isReallyGoodBot = stripos($lookUpResult, $goodBot);
			if ($isReallyGoodBot) {
				break;
			}
		}
		
		$user							= JFactory::getUser();
		$status							= $user->guest;
		
		$botArray 						= array();
		/* The below bots are in the CORE release as well as PRO */
		$componentParams->get('80legs', 0) == 0 ? 								$botArray[] = '80legs' : '';
		$componentParams->get('baiduspider', 0) == 0 ? 							$botArray[] = 'Baiduspider' : '';
		$componentParams->get('screamingfrogseospider', 0) == 0 ? 				$botArray[] = 'Screaming\ Frog\ SEO\ Spider' : '';
		$componentParams->get('verticalpigeon', 0) == 0 ? 						$botArray[] = 'verticalpigeon.com' : '';
		$componentParams->get('wget', 0) == 0 ? 								$botArray[] = 'Wget' : '';
		$componentParams->get('nutch', 0) == 0 ? 								$botArray[] = 'Nutch' : '';
		
		$botArray = implode("|", $botArray);
		$botArray = '/\b('.$botArray.')\b/i';
		
	/*
	 * DMC Firewall - SQL Injection attempts
	 */
		//$sql_needles 					= array('/**/', 'UNION+SELECT', 'union all select', '#__users', 'jos_users','concat(' ,'0x26,', '0x25,', '0x3a5f', '0x5f3a');
		$sql_needles = explode(';', $componentParams->get('sqlInjections', '/**/;UNION+SELECT;union all select;#__users;jos_users;concat(;0x26;0x25;0x3a5f;0x5f3a'));
		
		$sql_haystack					= array();
		$sql_haystack['post']			= print_r($_POST, true);	// posted data captured as a string
		$sql_haystack['get']			= print_r($_GET, true);		// 'get' data captured as a single string

		// cycle through each of the haystacks
		if (!$testMode) {
			foreach($sql_haystack as $sql_haystack) {
				$isSQLNaughty 				= $this->strpos_array($sql_haystack, $sql_needles);
				$explodedNaughtySQL = explode(',', $isSQLNaughty);
				
				if ($isSQLNaughty) {
					if ($isReallyGoodBot !== false) {
						break;
					}
					else {
						$simpleReason 		= 'SQL Injection Attempt';
						
						$additionalInformation = 'Requested URI: ' . $requestURI . '<br />Illegal content: \'' . $explodedNaughtySQL[1] . '\'';
						echo $additionalInformation;
						$this->blockNow($simpleReason, $ipAddress, $additionalInformation);
						break;
					}
				}
			}
		}
	/*
	 * DMC Firewall - END of SQL Injection attempts
	 */
	
	
	/*
	 * DMC Firewall - Hack attempts
	 */
		$hackArray = explode(';', $componentParams->get('hackAttempts', 'mosConfig_;proc/self/;proc/self/environ%0000;_REQUEST;GLOBALS;base64_encode;%0000;.txt?;../../../;http://'));
		
		$hackHaystack					= array();
		$hackHaystack['post']			= print_r($_POST, true);		// 'post' data captured as a string
		$hackHaystack['get']			= print_r($_GET, true);			// 'get' data captured as a string
		
		// cycle through each of the haystacks
		if (!$testMode) {
			foreach($hackHaystack as $key => $hackItem) {
				
				$isHackNaughty = $this->strpos_array($hackItem, $hackArray);
					
				$explodedNaughtyHack = explode(',', $isHackNaughty);
				
				if ($explodedNaughtyHack[0]) {
					if ($isReallyGoodBot !== false) {
						break;
					}
					else {
						$simpleReason 				= 'Hack Attempt';
						
						$additionalInformation = 'Requested URI: ' . $requestURI . '<br />Illegal content within \'' . $key . '\' data<br />\'' . $key . '\' data contained \'' . $explodedNaughtyHack[1] . '\'';
						$this->blockNow($simpleReason, $ipAddress, $additionalInformation);
						break;
					}
				}
				
			}
		}
	/*
	 * DMC Firewall - END of Hack attempts
	 */
	
	/*
	 * DMC Firewall - Bad Bots
	 */
		if (!$testMode) {
			if (preg_match($botArray, $userAgent)) {
				if ($isReallyGoodBot !== false) {
					break;
				}
				else {
					$simpleReason 			= 'Known Bad Bot';
					$this->blockNow($simpleReason, $ipAddress, $queryString);
				}
			}
		}
	/*
	 * DMC Firewall - END of Bad Bots section
	 */
	}
	
	/*
	 * blockNow function - The below function will attempt to block the IP address
	 * of the 'bad user' by adding their IP address to the websites '.htaccess' file.
	 * It will also send an email to the web master informing them that the user has been
	 * banned and what for.
	 */
	private function blockNow($simpleReason, $ipAddress, $additionalInformation) {
		require_once JPATH_ADMINISTRATOR . '/components/com_dmcfirewall/version.php';
		$componentParams 				= JComponentHelper::getParams('com_dmcfirewall');
		$app							= JFactory::getApplication();
		$configSitename					= $app->getCfg('sitename');
		$configMailfrom					= $app->getCfg('mailfrom');
		$osCheck						= strtoupper(substr(php_uname(), 0, 3));
		$securityCheck					= md5(DMCFIREWALL_VERSION);
		$_SERVER['HTTP_HOST']			= $_SERVER['HTTP_HOST'] . ',' . $securityCheck;
		
		jimport('joomla.version');
		$jVersion = new JVersion();
		
		$logFilePath					= JPATH_ADMINISTRATOR . '/components/com_dmcfirewall/logs/dmcfirewall_log.php';
		$errorLogPath					= JPATH_ADMINISTRATOR . '/components/com_dmcfirewall/logs/dmcfirewall_error_log.php';
	
	/* Determine what OS we are on */
		switch ($osCheck) {
			case 'LIN':
				$serverFile				= JPATH_SITE . '/.htaccess';
				$fileFlag				= '.htaccess';
			break;
			case 'WIN':
				$serverFile				= JPATH_SITE . '/web.config';
				$fileFlag				= 'web.config';
			break;
		}
	/* Determine what OS we are on */
		
		$theDate						= date('Y-m-d');
		$theTime						= date('H:i:s');
		
		$simpleReasonArray = array(
			'SQL Injection Attempt'		=> 'SQL Injection Attempt',
			'Failed Login'				=> 'Failed login attempt',
			'Known Bad Bot'				=> 'spider / bad bot / offline browser',
			'Hack Attempt'				=> 'Hack Attempt'
		);
		$expandedReasonArray = array(
			'SQL Injection Attempt'		=> $additionalInformation,
			'Known Bad Bot'				=> $_SERVER['HTTP_USER_AGENT'],
			'Failed Login'				=> $additionalInformation,
			'Hack Attempt'				=> $additionalInformation
		);
		
		$databaseColumnArray = array(
			'Known Bad Bot' 			=> 'bot_attempts_prevented',
			'SQL Injection Attempt'		=> 'sql_attempts_prevented',
			'Hack Attempt'				=> 'hack_attempts_prevented',
			'Failed Login'				=> 'bad_login_attempts'
		);
	
	/*
	 * Log Entry - The below lines add a record to the '$logFilePath' specified above
	 */
		$logEntry =<<<LOG_ENTRY

Date:			{$theDate}
Time: 			{$theTime}
IP Address: 	{$_SERVER['REMOTE_ADDR']}
Reason: 		{$simpleReasonArray[$simpleReason]}
User Agent: 	{$_SERVER['HTTP_USER_AGENT']}
Request Method:	{$_SERVER['REQUEST_METHOD']}
Request URI: 	{$_SERVER['REQUEST_URI']}
Referer:		{$_SERVER['HTTP_REFERER']}

LOG_ENTRY;
		
		//Add the entry into the log file specified above - safely
		$this->file_contents_write($logFilePath, $logEntry);
		
	/*
	 * Successful Email Template - The below section builds a HTML table which will be sent to the
	 * website administrator. We use tables as they will keep their 'shape' within emails
	 */
		$successfulEmailBody = $this->emailBody($simpleReasonArray[$simpleReason], $ipAddress, $_SERVER['HTTP_USER_AGENT'], $_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_SERVER['HTTP_REFERER']);
		
	/*
	 * Some simple checks to see if there is a '.htaccess' file that we
	 * can read and can write to - that is why we will chmod the file (if exists)
	 * so we can read and write to it
	 */
		if (!JFile::exists($serverFile)) {
			$this->die_friendly("<tr><td colspan=\"2\" style=\"border:1px solid #000;\">Sorry you don't have a '$fileFlag' file</td></tr>");
		}
		if (!is_readable($serverFile)) {
			$this->die_friendly("<tr><td colspan=\"2\" style=\"border:1px solid #000;\">You have a '$fileFlag' file but I can't read it!</td></tr>");
		}
		if(!is_writeable($serverFile)) {
			if (!chmod($serverFile, 0644)) {
				$this->die_friendly("<tr><td colspan=\"2\" style=\"border:1px solid #000;\">You have a '$fileFlag' file - I can read it, but I can't write to it!</td></tr>");
			}
			else {
				/*
				 * We have successfully 'chomod'd the '.htaccess/web.config' file - we will now set
				 * a flag so we can close it back up once we're finished
				 */
				$serverFileMadeWritable = true;
			}
		}
		
	/*
	 * We then get the contents of the '.htaccess' file ready to add the new IP address, another 
	 * check to see if we get the contents and then we write to the file
	 */
		$serverFileContents				= $this->file_contents_read($serverFile);
		
		if (!$serverFileContents) {
			$this->die_friendly("<tr><td colspan=\"2\" style=\"border:1px solid #000;\">Your '$fileFlag' file was detected as being readable and writeable - but I failed to read it!</td></tr>");
		}
	
	/*
	 * Add the banned IP address to the '.htacess' or 'web.config' file so they can't keep trying to hack Joomla!. send
	 * an email letting the site webmaster know that someone has been banned and lock down the '.htaccess' file
	 * if we '$serverFileMadeWritable' flag is flying!
	 */
		/* We are on a Windows OS so we *should* have a 'web.config' file */
		if ($osCheck == 'WIN') {
			if(stripos($serverFileContents, "<!-- DMC Firewall - web.config block delimiter -->") === FALSE) {
				$this->die_friendly("<tr><td colspan=\"2\" style=\"border:1px solid #000;\">You have a 'web.config' file - But you don't have the ban IP section.</td></tr>");
			}
			else {
				$webconfigOutput 				= preg_replace('@<!-- DMC Firewall - web.config block delimiter -->@i', '<add input="{REMOTE_ADDR}" pattern="' . $ipAddress . "\" />\n\t\t\t\t\t\t<!-- DMC Firewall - web.config block delimiter -->", $serverFileContents);
				$this->file_contents_write($serverFile, $webconfigOutput, false);
			}
		}
		/* We are on a Linux OS so we *should* have a '.htaccess' file */
		elseif ($osCheck == 'LIN') {
			if(stripos($serverFileContents, '<Limit ') === FALSE) {
				$this->die_friendly("<tr><td colspan=\"2\" style=\"border:1px solid #000;\">You have a .htaccess file - But you don't have the Limit /Limit section.</td></tr>");
			}
			else {
				$htaccessOutput 				= preg_replace('@</Limit>@i', "deny from $ipAddress \n</Limit>", $serverFileContents);
				$this->file_contents_write($serverFile, $htaccessOutput, false);
			}
		}
		/* We have no idea what the OS is so we die! */
		else {
			$this->die_friendly("<tr><td colspan=\"2\" style=\"border:1px solid #000;\">We are unable to identify your OS so we are unable to block this user!<br />Please contact <a href=\"http://www.webdevelopmentconsultancy.com/contact-us.html\" target=\"_blank\">Dean Marshall Consultancy Ltd</a> so we are able to improve DMC Firewall!</td></tr>");
		}
	
		if ($serverFileMadeWritable) {
			chmod($serverFile, 0444);
		}
		
		/*
		 * Let's do some checking to see if we should send an email to the webmaster
		 */
		if (
			($simpleReason == 'Known Bad Bot' && $componentParams->get('emailsBadBots', 1) == 1) ||
			($simpleReason == 'Hack Attempt' && $componentParams->get('emailsHackAttempts', 1) == 1) ||
			($simpleReason == 'SQL Injection Attempt' && $componentParams->get('emailsSQLInjections', 1) == 1) ||
			($simpleReason == 'Failed Login' && $componentParams->get('emailsFailedLogins', 1) == 1)
		) {
			$this->sendMailFunction('', $successfulEmailBody);
		}
		
		
		$domainName					= $_SERVER['HTTP_HOST'];
		$domainTest					= substr($domainName, 0,4);
		
		if ($domainTest !== 'www.') {
			$fullDomainName = 'www.' . $domainName;
		}
		else {
			$fullDomainName = $domainName;
		}
		
		$vars = array(
			'reason'				=> $simpleReason,						// reason for ban
			'useragent'				=> $_SERVER['HTTP_USER_AGENT'],			//
			'request_method'		=> $_SERVER['REQUEST_METHOD'],			//
			'request'				=> $_SERVER['REQUEST_URI'],				//
 			'hackerIP'				=> $_SERVER['REMOTE_ADDR'],				// IP address of hacker
			
			'reporter'				=> $fullDomainName,						// web address of attacked server (reporter)
			'contactEmail'			=> $configMailfrom,						// The email address specified within Global Config
			'reporterIP'			=> $_SERVER['SERVER_ADDR'],				// IP address of attacked server (reporter)
			'version'				=> DMCFIREWALL_VERSION,					// The version of DMC Firewall
			'professional'			=> ISPRO								// Professional version or Core
		);
		$data = $this->doCallBack('POST', $vars);
		$db = JFactory::getDBO();
	
	/*
	 * With the returned '$data', let's do a simple check to see if there is an update, if there is - send an email to
	 * the webmaster informing them
	 */
		$query = "SELECT `last_update_email_time`, `last_scheduled_report_email_time` FROM `#__dmcfirewall_stats` WHERE `id` = 1";
		$db->setQuery($query);
		$db->query();
		$statsRecord = $db->loadAssoc();
		
		$decodedData = json_decode($data,true);
		$explodedJVersion = explode(',', $decodedData['joomlaVersions']);
		
	/*
	 * Let's check the returned data to see if an update is available, if there is an update available, let's see if our Joomla
	 * version matches the update and if it does, let's send the webmaster an email
	 */
		if ($decodedData['firewallVersion'] != DMCFIREWALL_VERSION && in_array($jVersion->RELEASE, $explodedJVersion) && $statsRecord['last_update_email_time'] <= time()) {
			switch($componentParams->get('updateEmailTime', 12)) {
				case 1:
					$updateTime = time() + 3600;
				break;
				case 3:
					$updateTime = time() + (3600 * 3);
				break;
				case 7:
					$updateTime = time() + (3600 * 7);
				break;
				case 12:
					$updateTime = time() + (3600 * 12);
				break;
				case 24:
					$updateTime = time() + (3600 * 24);
				break;
			}
			$emailOverrideParam				= $componentParams->get('emailOverride', NULL);
			$emailAddress					= (!strstr($emailOverrideParam, '@')) || (!strstr($emailOverrideParam, '')) ? $configMailfrom : $emailOverrideParam;

			$mailer							= JFactory::getMailer();
			$mailer->ClearAllRecipients();

			$mailer->setSender(array($configMailfrom, 'Update Available for DMC Firewall'));
			$mailer->addRecipient($emailAddress, $configSitename);
			$mailer->setSubject('Update Available for ' . $configSitename);
			$body = 'An update is available for DMC Firewall.<br /><br />DMC Firewall is a Joomla Security Extension that you have installed within your website!<br /><br />Please update as soon as possible!<br /><br />
			DMC Firewall is a script from<br />
			Dean Marshall Consultancy Ltd<br />
			http://www.deanmarshall.co.uk/<br />
			http://www.webdevelopmentconsultancy.com/';
			$mailer->isHTML(true);
			$mailer->setBody($body);
			
			$send = $mailer->Send();
			
			$db->setQuery("UPDATE `#__dmcfirewall_stats` SET `last_update_email_time` = '$updateTime' WHERE `id` = 1");
			$db->query();
		}
	
	/*
	 * Here we will see if 'Scheduled Reporting' is set to use the plugin and that we haven't sent them the report recently
	 */
		if ($componentParams->get('emailsEnableScheduledReporting', 1) == 1 && $componentParams->get('emailsScheduledReportingType', 0) == 0 && $statsRecord['last_scheduled_report_email_time'] <= time()) {
			switch($componentParams->get('emailsScheduledReportingTime', 3)) {
				case 1:
					$scheduledReportTime = time() + 86400;
				break;
				case 3:
					$scheduledReportTime = time() + (86400 * 3);
				break;
				case 7:
					$scheduledReportTime = time() + (86400 * 7);
				break;
				case 12:
					$scheduledReportTime = time() + (86400 * 14);
				break;
				case 24:
					$scheduledReportTime = time() + (86400 * 31);
				break;
			}
			
			require JPATH_ADMINISTRATOR . '/components/com_dmcfirewall/helpers/graphstats.php';
			$graphContent			= DmcfirewallGraphStatsHelper::buildScheduledReport($componentParams->get('emailsScheduledReportingReportDuration', 7));
			
			$emailOverrideParam		= $componentParams->get('emailOverride', NULL);
			$emailAddress			= (!strstr($emailOverrideParam, '@')) || (!strstr($emailOverrideParam, '')) ? $configMailfrom : $emailOverrideParam;
			
			$mailer = JFactory::getMailer();
			$mailer->ClearAllRecipients();

			// Build the parts of the email - sender, recipient, subject, email body
			$mailer->setSender(array($configMailfrom, $configSitename));
			$mailer->addRecipient($emailAddress, $configSitename);
			$mailer->setSubject('DMC Firewall Scheduled Report');
			$mailer->isHTML(true);
			$mailer->setBody($graphContent);
			
			// Send the email
			$send = $mailer->Send();
			
			$db->setQuery("UPDATE `#__dmcfirewall_stats` SET `last_scheduled_report_email_time` = '$scheduledReportTime' WHERE `id` = 1");
			$db->query();
		}
	/*
	 * Create a database object and insert a new log within the `#__dmcfirewall_log` table
	 */
		$safeAdditionalInfo = $db->escape($expandedReasonArray[$simpleReason]);
		$db->setQuery("INSERT INTO `#__dmcfirewall_log` (`ip`, `reason`, `additional_information`, `time_date`) 
						VALUES ('$ipAddress', '" . $simpleReason . "', '" . $safeAdditionalInfo . "', '$theDate - $theTime')");
		$result = $db->query();
		
	/*
	 * Update the `#__dmcfirewall_stats` table incrementing the relevant field
	 */
		$db->setQuery("UPDATE `#__dmcfirewall_stats` SET $databaseColumnArray[$simpleReason]=$databaseColumnArray[$simpleReason]+1, `attacks_prevented`=`attacks_prevented`+1 WHERE `id` = 1");
		$result = $db->query();
		
		return die('You have been banned by our Firewall script, This script was created by Dean Marshall Consultancy Ltd at <a href="http://www.webdevelopmentconsultancy.com/" target="_blank">Joomla Security Experts</a>');
	}
	
	/*
	 * Send an email to the 'webmaster'. By default this will be the setting which is stored within Global Config
	 * - If an email address has been entered within DMC Firewall's Configuration the email will be sent to the 
	 * address specified
	 */
	private function sendMailFunction($subject, $additional_info, $status = NULL) {
		$app							= JFactory::getApplication();
		$configSitename					= $app->getCfg('sitename');
		$configDomain					= JURI::root();
		$configDomainSplit				= explode(',', $configDomain);
		$configMailfrom					= $app->getCfg('mailfrom');
		$componentParams				= JComponentHelper::getParams('com_dmcfirewall');
		$enableEmailsParam				= $componentParams->get('enableEmails', 2);
		$emailOverrideParam				= $componentParams->get('emailOverride', NULL);
		
		$subject						= !$subject ? $configSitename . ' - DMC Firewall just banned someone from your website' : $configSitename . ' - ' . 'DMC Firewall Error';
		$emailAddress					= (!strstr($emailOverrideParam, '@')) || (!strstr($emailOverrideParam, '.')) ?  $configMailfrom : $emailOverrideParam;
		// Concatenate the email 'parts' and send
		$message						= $this->emailHeader($configSitename, $configDomainSplit[0]) . "\r\n" . $additional_info . "\r\n" . $this->emailFooter();
		
		$mailer							= JFactory::getMailer();
		$mailer->ClearAllRecipients();
		
		//build the parts of the email - sender, recipient, subject, email body
		$mailer->setSender(array($configSitename, $configMailfrom));
		$mailer->addRecipient($emailAddress, $configSitename);
		
		$mailer->setSubject($subject);
		$mailer->setBody($message);
		$mailer->isHTML(true);
			
		// The email is sent below using the JMailer function
		$subject						= !$subject ? $configSitename . ' - ' . 'DMC Firewall just banned someone from your website' : $configSitename . ' - ' . 'DMC Firewall Error';
		if ($enableEmailsParam != 0) {
				$send = $mailer->Send();
		}
	}
	
	private function file_contents_read($filename) {
		$contents						= '';
		$fp = fopen ($filename, "r");
		if ($fp) {
			$startTime = microtime();
			do {
				$canRead = flock($fp, LOCK_EX | LOCK_NB);
				// If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
				if (!$canRead) {
					usleep(round(rand(0, 100)*1000));
				}
			}
			while ((!$canRead) and ((microtime()-$startTime) < 1000));
			
			//file was locked so now we can store information
			if ($canRead) {
				$contents = fread($fp, filesize($filename));
			}
			fclose ($fp); 
		}
		else {
			echo "ERROR";
			$contents = '';
		}
		return $contents;
	}

	private function file_contents_write($filename, $contents, $append=true) {
		$method						= ($append) ? 'a' : 'w';
	
		// waiting until file will be locked for writing (1000 milliseconds as timeout)
		if ($fp = fopen($filename, $method)) {
			$startTime = microtime();
			do {
				$canWrite = flock($fp, LOCK_EX | LOCK_NB);
				// If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
				if (!$canWrite) {
					usleep(round(rand(0, 100)*1000));
				}		
			}
			while ((!$canWrite) and ((microtime()-$startTime) < 1000));

			//file was locked so now we can store information
			if ($canWrite) {
				fwrite($fp, $contents);
			}
			fclose($fp);
		}
	}
	
	function die_friendly($errorMsg) {
		$this->sendMailFunction('DMC Firewall - Error', $errorMsg, $status = 'Error');
		$this->file_contents_write($error_log, 'Hacking attempt from IP Address: ' . $_SERVER['REMOTE_ADDR']. "\r\n" . $errorMsg, true);
		exit();	
	}
	
	private function strpos_array($haystacker, $needler) {
		foreach ($needler as $what) {
			if (($pos = stripos($haystacker, $what)) !== false) {
				return $pos . ',' . $what;
			}
		}
		return false;
	}
	
	/*
	 * Email templates
	 */
	private function emailHeader($siteName, $domainPath) {
		$theDate						= date('M d Y');
		$theTime						= date('H:i:s');
		
		$headerContents =<<<EMAIL_TEMPLATE_TOP
		This is a security alert from the automated 'DMC Firewall Script' installed on your Joomla powered website:<br />
<table width="750px" style="margin-left:25px; margin-top:15px; margin-bottom:15px; border-collapse:collapse;">
	<tr>
		<td width="250px" style="border:1px solid #000;">Site Name</td>
		<td width="450px" style="border:1px solid #000;">{$siteName}</td>
	</tr>
	<tr>
		<td style="border:1px solid #000;">Domain</td>
		<td style="border:1px solid #000;">{$domainPath}</td>
	</tr>
	<tr>
		<td style="border:1px solid #000;">Date - Time</td>
		<td style="border:1px solid #000;">{$theDate} - {$theTime}</td>
	</tr>
EMAIL_TEMPLATE_TOP;
		
		return $headerContents;
	}
	
	private function emailBody($reason, $ip, $ua, $rm, $ru, $ref) {
		$bodyContents =<<<MESSAGE_BODY
	<tr>
		<td width="250px" style="border:1px solid #000;">Reason</td>
		<td width="450px" style="border:1px solid #000;">{$reason}</td>
	</tr>
	<tr>
		<td style="border:1px solid #000;">IP Address</td>
		<td style="border:1px solid #000;">{$ip}</td>
	</tr>
	<tr>
		<td style="border:1px solid #000;">User Agent</td>
		<td style="border:1px solid #000;">{$ua}</td>
	</tr>
	<tr>
		<td style="border:1px solid #000;">Request Method</td>
		<td style="border:1px solid #000;">{$rm}</td>
	</tr>
	<tr>
		<td style="border:1px solid #000;" valign="top">Request URI</td>
		<td style="border:1px solid #000;">{$ru}</td>
	</tr>
	<tr>
		<td style="border:1px solid #000;">Referer</td>
		<td style="border:1px solid #000;">{$ref}</td>
	</tr>
MESSAGE_BODY;
	
		return $bodyContents;
	}
	
	private function emailFooter() {
		$footerContents =<<<EMAIL_TEMPLATE_BOTTOM
		</table>
		DMC Firewall is a script from<br />
		Dean Marshall Consultancy Ltd<br />
		http://www.deanmarshall.co.uk/<br />
		http://www.webdevelopmentconsultancy.com/
EMAIL_TEMPLATE_BOTTOM;
		
		return $footerContents;
	}
	
	private function doCallBack($method, $vars) {
		$user_agent = "DMC Firewall";
		$url = "http://www.webdevelopmentconsultancy.com/downloads/fw_callback.php";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		}

		$data = curl_exec($ch);
		curl_close($ch);
		if ($data) {
			return $data;
		}
	}
}