CREATE TABLE IF NOT EXISTS `#__comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `contentid` int(10) NOT NULL DEFAULT '0',
  `component` varchar(50) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `website` varchar(100) NOT NULL DEFAULT '',
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `spam` tinyint(1) NOT NULL DEFAULT '0',
  `voting_yes` int(10) NOT NULL DEFAULT '0',
  `voting_no` int(10) NOT NULL DEFAULT '0',
  `parentid` int(10) NOT NULL DEFAULT '-1',
  `importtable` varchar(30) NOT NULL DEFAULT '',
  `importid` int(10) NOT NULL DEFAULT '0',
  `importparentid` int(10) NOT NULL DEFAULT '-1',
  `unsubscribe_hash` VARCHAR( 255 ) NOT NULL ,
  `moderate_hash` VARCHAR( 255 ) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `com_contentid` (`component`,`contentid`)
) CHARACTER SET `utf8` COLLATE `utf8_general_ci`;


CREATE TABLE IF NOT EXISTS `#__comment_captcha` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `insertdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `referenceid` varchar(100) NOT NULL DEFAULT '',
  `hiddentext` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) CHARACTER SET `utf8` COLLATE `utf8_general_ci`;

CREATE TABLE IF NOT EXISTS `#__comment_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` varchar(50) NOT NULL DEFAULT '',
  `component` varchar(50) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET `utf8` COLLATE `utf8_general_ci`;

CREATE TABLE IF NOT EXISTS `#__comment_voting` (
  `id` int(10) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT '0'
) CHARACTER SET `utf8` COLLATE `utf8_general_ci`;

CREATE TABLE IF NOT EXISTS `#__comment_version` (
  `id` int(11) NOT NULL,
  `version` varchar(55) NOT NULL
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__comment_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailfrom` varchar(255) DEFAULT NULL,
  `fromname` varchar(255) DEFAULT NULL,
  `recipient` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'html',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) DEFAULT CHARSET=utf8;