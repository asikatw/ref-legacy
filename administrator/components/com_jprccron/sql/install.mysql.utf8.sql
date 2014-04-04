DROP TABLE IF EXISTS `#__jprccron_tasks`;

CREATE TABLE `#__jprccron_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `mhdmd` varchar(255) NOT NULL DEFAULT '',
  `file` varchar(255) NOT NULL DEFAULT '',
  `ran_at` datetime DEFAULT NULL,
  `ok` tinyint(4) NOT NULL DEFAULT '0',
  `log_text` longtext NOT NULL,
  `unix_mhdmd` varchar(255) NOT NULL DEFAULT '',
  `last_run` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ;