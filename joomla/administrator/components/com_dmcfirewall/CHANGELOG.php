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
?>
DMC Firewall - 1.2
================================================================================
+ Compatibility with Joomla 3.2
+ You can now add/remove common hacker 'terms' that DMC Firewall will block or allow
+ You can now add/remove common SQL Injection 'terms' that DMC Firewall will block or allow
+ You can now set what emails to receive from DMC Firewall when someone is banned - thanks @jacob_dixon
+ You now receive an email when an update is available
+ You can now allow comments within your website without users being banned
+ Full compliance with the Joomla Extension Directory [Core and Pro]
+ [PRO] You are now able to password protect the 'administrator' area of your website
+ You are now able to view a 'run down' of what DMC Firewall has blocked in the last week
+ DMC Firewall Statistics Module now displays 4 icons for ease of use (update status, configuration, attack summary, global configuration)
+ DMC Firewall Statistics Module now displays the 'Attack Summary' information
+ Additional words added to 'DMC Content Sniffer'
+ [PRO] Additional 'bad bots' added
+ [CORE] A number of 'bad bots' are now included within the CORE release
+ You can now configure what information is displayed within the 'Statistics Module'
+ Scheduled Reporting has been added, this sends a breakdown of what's been banned in the last x days
! [PRO] Error relating to 'Unable to load view' when you tried to change the default Super Admin ID
# Improvements to the 'Bad Bot' detection
# Edits to your '.htaccess' file after using Akeeba's Admin Tools 'Htaccess Maker' - thanks dpottier
# Content Sniffer now obeys the 'Email Override' setting with DMC Firewall Configuration
# [PRO] Better log details for Failed Login attempts
# The 'Take a backup' button now pops-up instead of taking you directly to the Akeeba backup control panel
# Language string fixes (spellings) - thanks @TJDixonLimited - @jacob_dixon - dpottier
# [PRO] The centralised server now stores bad username and password combinations
# HTML mark-up corrected within 'Content Sniffer'
# Language string fixes (wrong language strings loading)
# Issue when you had Akeeba Backup installed but disabled - the 'back up' icon would be displayed but would return a blank page once clicked
# Fixed display issue within the error email that gets sent out when an error occurs
~ Emails are now sent with JMailer instead of PHP's mail within 'plg_dmcfirewall'
~ 'Bad Content Settings' have moved to a new tab titled 'Security Settings' with additional settings
~ Better reporting with regards to SQL Injection attempts

DMC Firewall - 1.1
================================================================================
! 'plg_dmcfirewall' reported that every bad attempt was a 'good bad' so wouldn't ban the bad attempts [Core]

DMC Firewall - 1.0
================================================================================
+ DMC Firewall version 1.0 released!