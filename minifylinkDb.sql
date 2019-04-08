-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_link` varchar(255) NOT NULL COMMENT 'Souirce link',
  `link` varchar(255) DEFAULT NULL COMMENT 'Final link',
  `create_time` datetime DEFAULT NULL COMMENT 'Created at',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `source_link_UNIQUE` (`source_link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `link` (`id`, `source_link`, `link`, `create_time`) VALUES
(1,	'https://mail.ru/',	'6yWTw15g',	'2019-04-08 22:39:17'),
(2,	'https://www.google.com/',	'CR7jj3Mq',	'2019-04-08 22:54:17');

-- 2019-04-08 18:02:50
