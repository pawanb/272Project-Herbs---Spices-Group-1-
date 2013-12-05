<?php
/**
 * @Package			DMC Firewall
 * @Copyright		Dean Marshall Consultancy Ltd
 * @license			http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Email			software@deanmarshall.co.uk
 * web:				http://www.deanmarshall.co.uk/
 * web:				http://www.webdevelopmentconsultancy.com/
 */

define('_JEXEC', 1);

/*
 * Load Joomla system files
 */
define('JPATH_BASE', dirname(__FILE__).'/../');
require_once JPATH_BASE . '/includes/defines.php';

// Load the rest of the framework include files
// Load the rest of the framework include files
if (file_exists(JPATH_LIBRARIES . '/import.legacy.php')) {
	require_once JPATH_LIBRARIES . '/import.legacy.php';
}
else {
	require_once JPATH_LIBRARIES . '/import.php';
}
require_once JPATH_LIBRARIES . '/cms.php';

// Load the JApplicationCli class
JLoader::import( 'joomla.application.cli' );

/*
 * DMC Firewall Scheduled Reporting CLI application
 */
class DMCFirewallScheduledReportingCLI extends JApplicationCli {
	/*
	 * @param JInputCli $input
	 * @param JRegistry $config
	 * @param JDispatcher $dispatcher
	 */
	public function __construct(JInputCli $input = null, JRegistry $config = null, JDispatcher $dispatcher = null) {
		// Close the application if we are not executed from the command line
		if( array_key_exists('REQUEST_METHOD', $_SERVER) ) {
			//die('You are not supposed to access this script from the web. You have to run it from the command line. If you don\'t understand what this means, you must not try to use this file before reading the documentation. Thank you.');
		}

		// If a input object is given use it.
		if ($input instanceof JInput) {
			$this->input = $input;
		}
		// Create the input based on the application logic.
		else {
			if (class_exists('JInput')) {
				$this->input = new JInputCLI;
			}
		}

		// If a config object is given use it.
		if ($config instanceof JRegistry) {
			$this->config = $config;
		}
		// Instantiate a new configuration object.
		else {
			$this->config = new JRegistry;
		}

		// If a dispatcher object is given use it.
		if ($dispatcher instanceof JDispatcher) {
			$this->dispatcher = $dispatcher;
		}
		// Create the dispatcher based on the application logic.
		else {
			$this->loadDispatcher();
		}

		// Load the configuration object.
		$this->loadConfiguration($this->fetchConfigurationData());

		// Set the execution datetime and timestamp;
		$this->set('execution.datetime', gmdate('Y-m-d H:i:s'));
		$this->set('execution.timestamp', time());

		// Set the current directory.
		$this->set('cwd', getcwd());
	}
	
	/*
	 * Execute the Scheduled Report
	 */
	public function execute() {
		$component				= JComponentHelper::getComponent('com_dmcfirewall');
		$componentParams		= $component->params;
		$reportDays				= $componentParams->get('emailsScheduledReportingReportDuration', 7);
		$emailOverrideParam		= $componentParams->get('emailOverride', NULL);
		// Pre-Load configuration.
		ob_start();
		require_once JPATH_CONFIGURATION . '/configuration.php';
		ob_end_clean();

		// System configuration.
		$config = new JConfig;
		//$app					= JFactory::getApplication();
		$configSitename			= $config->sitename;
		$configMailfrom			= $config->mailfrom;
		
		require JPATH_ADMINISTRATOR . '/components/com_dmcfirewall/helpers/graphstats.php';
		$graphContent			= DmcfirewallGraphStatsHelper::buildScheduledReport($reportDays);
		
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
		
	}
}

// Instanciate and run the application
JApplicationCli::getInstance('DMCFirewallScheduledReportingCLI')->execute();