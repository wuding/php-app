-- Adminer 5.2.1 MySQL 5.7.36-log dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tip_domain_zone`;
CREATE TABLE `tip_domain_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `idc` int(11) DEFAULT NULL,
  `vps` int(11) DEFAULT NULL,
  `registration` double DEFAULT NULL,
  `renewal` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `avg` double DEFAULT NULL,
  `domain` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reg` datetime DEFAULT NULL,
  `exp` datetime DEFAULT NULL,
  `ssl_exp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tip_vps`;
CREATE TABLE `tip_vps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idc` int(11) DEFAULT NULL,
  `cups` int(11) DEFAULT NULL,
  `ram` int(11) DEFAULT NULL,
  `disk` int(11) DEFAULT NULL,
  `bandwidth` int(11) DEFAULT NULL,
  `display_port` int(11) DEFAULT NULL,
  `year` double DEFAULT NULL,
  `month` double DEFAULT NULL,
  `day` double DEFAULT NULL,
  `exp` datetime DEFAULT NULL,
  `ip` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2025-04-24 13:02:00 UTC
