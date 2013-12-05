CREATE TABLE IF NOT EXISTS `#__jcomments_mailq` (
`id` int(11) NOT NULL auto_increment,
`name` varchar(255) NOT NULL,
`email` varchar(255) NOT NULL,
`subject` text NOT NULL,
`body` text NOT NULL,
`created` datetime NOT NULL,
`attempts` tinyint(1) NOT NULL DEFAULT '0',
`priority` tinyint(1) NOT NULL DEFAULT '0',
`session_id` VARCHAR(200) DEFAULT NULL,
PRIMARY KEY  (`id`),
KEY `idx_priority` (`priority`),
KEY `idx_attempts` (`attempts`)
) DEFAULT CHARSET=utf8;

ALTER IGNORE TABLE `#__jcomments_objects` CHANGE `link` `link` TEXT NOT NULL DEFAULT '';
ALTER IGNORE TABLE `#__jcomments_objects` ADD `category_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER `object_group`;
ALTER IGNORE TABLE `#__jcomments_subscriptions` ADD `checked_out` INT(11) UNSIGNED NOT NULL DEFAULT '0';
ALTER IGNORE TABLE `#__jcomments_subscriptions` ADD `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER IGNORE TABLE `#__jcomments_custom_bbcodes` ADD `checked_out` INT(11) UNSIGNED NOT NULL DEFAULT '0';
ALTER IGNORE TABLE `#__jcomments_custom_bbcodes` ADD `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';

CREATE TABLE IF NOT EXISTS `#__jcomments_smilies` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`code` varchar(39) NOT NULL DEFAULT '',
`alias` varchar(39) NOT NULL DEFAULT '',
`image` varchar(255) NOT NULL,
`name` varchar(255) NOT NULL,
`published` tinyint(1) NOT NULL DEFAULT '0',
`ordering` int(11) unsigned NOT NULL DEFAULT '0',
`checked_out` int(11) unsigned NOT NULL DEFAULT '0',
`checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`),
KEY `idx_checkout` (`checked_out`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;


UPDATE `#__jcomments_settings` SET `name` = 'enable_mambots' WHERE `name` = 'enable_plugins';
UPDATE `#__jcomments_settings` SET `name` = 'comments_list_order' WHERE `name` = 'comments_order';
UPDATE `#__jcomments_settings` SET `name` = 'comments_tree_order' WHERE `name` = 'tree_order';
UPDATE `#__jcomments_settings` SET `name` = 'smilies' WHERE `name` = 'smiles';
UPDATE `#__jcomments_settings` SET `name` = 'enable_smilies' WHERE `name` = 'enable_smiles';
UPDATE `#__jcomments_settings` SET `name` = 'smilies_path' WHERE `name` = 'smiles_path';
UPDATE `#__jcomments_settings` SET `value` = '/components/com_jcomments/images/smilies/' WHERE `value` = '/components/com_jcomments/images/smiles/';
