CREATE TABLE IF NOT EXISTS `#__dmcfirewall_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` varchar(150) NOT NULL,
  `additional_information` varchar(255) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `time_date` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__dmcfirewall_stats` (
  `id` TINYINT NOT NULL AUTO_INCREMENT,
  `attacks_prevented` smallint(6) NOT NULL,
  `bot_attempts_prevented` smallint(6) NOT NULL,
  `sql_attempts_prevented` smallint(6) NOT NULL,
  `hack_attempts_prevented` smallint(6) NOT NULL,
  `bad_login_attempts` smallint(6) NOT NULL,
  `last_update_email_time` int(11) NOT NULL DEFAULT '0',
  `last_scheduled_report_email_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__dmcfirewall_login` (
  `id` TINYINT NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(50) NOT NULL,
  `reason` varchar(75) NOT NULL,
  `time_date` varchar(50) NOT NULL,
  `time_stamp` int(11) NOT NULL,
  `username` VARCHAR(150) NOT NULL,
  `password` VARCHAR(200) NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8 AUTO_INCREMENT=1 ;

INSERT IGNORE INTO `#__dmcfirewall_stats`
(`id`,`attacks_prevented`, `bot_attempts_prevented`, `sql_attempts_prevented`, `hack_attempts_prevented`, `last_update_email_time`, `last_scheduled_report_email_time`) VALUES
(1, 0, 0, 0, 0, 0, 0);