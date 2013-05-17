DROP TABLE IF EXISTS `yeedt_trans`;
CREATE TABLE `yeedt_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `author` varchar(32) DEFAULT NULL,
  `en_title` varchar(255) DEFAULT NULL,
  `en_content` text,
  `status` varchar(32) DEFAULT 'new',
  `order_id` varchar(32) DEFAULT NULL,
  `yeedt_order_id` varchar(32) DEFAULT NULL,
  `languages` varchar(32) DEFAULT NULL,
  `qualityLevels` varchar(32) DEFAULT NULL,
  `wordCount` int(11) DEFAULT NULL,
  `price` varchar(32) DEFAULT NULL,
  `languages_key` varchar(32) DEFAULT NULL,
  `qualityLevels_key` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yeedt_msg`;
CREATE TABLE `yeedt_msg` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg` varchar(255) DEFAULT NULL,
  `posttime` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `type` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;