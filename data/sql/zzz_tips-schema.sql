-- Adminer 5.3.0 MySQL 5.7.36-log dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tip_domain_zone`;
CREATE TABLE `tip_domain_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flag` int(11) DEFAULT NULL,
  `del` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT NULL,
  `idc` int(11) DEFAULT NULL,
  `vps` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
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

INSERT INTO `tip_domain_zone` (`id`, `flag`, `del`, `uid`, `idc`, `vps`, `year`, `registration`, `renewal`, `total`, `avg`, `domain`, `reg`, `exp`, `ssl_exp`) VALUES
(1, 2,  0,  NULL, 112,  1,  NULL, 35, 70, 239,  29.875, 'tutorial.pub', '2017-04-01 18:40:30',  '2026-04-01 18:40:30',  '2025-09-01 07:59:59'),
(2, 2,  0,  NULL, 112,  2,  NULL, 32, 45, NULL, NULL, 'jiedian.wang', '2024-11-06 04:07:17',  '2025-11-06 04:07:17',  '2025-09-03 07:59:59'),
(3, 1,  0,  NULL, 112,  1,  10, 188,  NULL, 188,  18.8, 'softcool.top', '2024-11-06 04:17:43',  '2034-11-06 04:17:43',  '2025-09-16 07:59:59'),
(4, 1,  0,  NULL, 112,  1,  10, 199,  NULL, 199,  19.9, 'jiedian.store',  '2024-11-06 04:25:07',  '2034-11-06 07:59:59',  '2025-09-16 07:59:59'),
(5, 1,  0,  NULL, 112,  2,  10, 188,  NULL, 188,  18.8, 'coolapp.top',  '2025-02-08 21:19:31',  '2035-02-08 21:19:31',  '2025-08-08 07:59:59'),
(6, 7,  0,  NULL, 112,  2,  NULL, 50, 70, NULL, NULL, 'uuu.show', '2025-02-09 12:09:19',  '2026-02-09 12:09:19',  '2025-09-01 07:59:59'),
(7, 7,  0,  NULL, 112,  2,  NULL, 10, 98, NULL, NULL, 'uuu.hair', '2025-02-09 16:41:34',  '2026-02-10 07:59:59',  '2025-09-01 07:59:59'),
(8, 7,  0,  NULL, 112,  2,  NULL, 10, 98, NULL, NULL, 'uuu.skin', '2025-02-09 16:41:34',  '2026-02-10 07:59:59',  '2025-09-01 07:59:59'),
(9, 2,  0,  NULL, 141,  4,  16, 64, 77.58,  1152, 72, 'urlnk.com',  '2010-03-10 18:20:18',  '2027-03-10 17:20:18',  '2025-07-27 07:59:59'),
(10,  2,  0,  NULL, 141,  5,  1,  86.36,  79.85,  NULL, NULL, 'movcd.com',  '2024-06-05 00:00:00',  '2026-06-05 00:00:00',  '2025-08-16 07:59:59'),
(11,  -10,  -1, NULL, 141,  1,  1,  13.66,  114.83, NULL, NULL, 'jiedian.one',  '2024-08-05 00:00:00',  '2025-08-05 00:00:00',  '2025-09-16 07:59:59'),
(12,  4,  -1, NULL, 141,  5,  1,  28.11,  71.47,  NULL, NULL, 'movcd.cc', '2024-10-07 00:00:00',  '2025-10-07 00:00:00',  '2025-09-16 07:59:59'),
(13,  NULL, 0,  NULL, 141,  1,  1,  12.86,  34.54,  NULL, NULL, 'zisee.top',  '2024-11-09 00:00:00',  '2025-11-09 00:00:00',  '2025-08-04 23:25:46'),
(14,  2,  0,  NULL, 141,  1,  5,  77.97,  77.25,  386.97, 77.394, 'urlnk.org',  '2020-12-24 00:00:00',  '2025-12-24 00:00:00',  '2025-09-16 07:59:59'),
(15,  7,  0,  NULL, 141,  1,  1,  179.87, 179.87, NULL, NULL, 'zzz.spa',  '2025-01-08 00:00:00',  '2026-01-08 00:00:00',  '2025-09-13 07:59:59'),
(16,  7,  0,  NULL, 141,  1,  1,  78.05,  176.25, NULL, NULL, 'zzz.tips', '2025-01-08 00:00:00',  '2026-01-08 00:00:00',  '2025-09-13 07:59:59'),
(17,  7,  0,  NULL, 141,  1,  1,  143.73, 143.73, NULL, NULL, 'zzz.kids', '2025-01-08 00:00:00',  '2026-01-08 00:00:00',  '2025-09-13 07:59:59'),
(18,  7,  0,  NULL, 141,  5,  1,  13.66,  194.32, NULL, NULL, 'zzz.pics', '2025-01-08 00:00:00',  '2026-01-09 00:00:00',  '2025-09-13 07:59:59'),
(19,  2,  0,  NULL, 141,  2,  1,  179.87, 179.87, NULL, NULL, 'coolapp.ooo',  '2025-02-08 00:00:00',  '2026-02-08 00:00:00',  '2025-08-08 07:59:59'),
(20,  4,  0,  NULL, 425,  5,  NULL, 59.53,  125.5,  NULL, NULL, 'mov.red',  '2025-01-30 22:31:16',  '2026-01-30 22:31:16',  '2025-08-29 07:59:59'),
(21,  2,  0,  NULL, 425,  2,  NULL, 88.26,  107.9,  NULL, NULL, 'softcool.app', '2025-02-09 08:58:28',  '2026-02-09 08:58:28',  '2025-07-09 04:44:52'),
(22,  -1, -1, NULL, 914,  2,  NULL, 157.64, 141.04, NULL, NULL, 'helenamattsson.se',  '2025-03-31 00:00:00',  '2026-03-31 00:00:00',  '2025-09-28 00:00:00'),
(23,  10, 0,  NULL, NULL, NULL, NULL, 77.36,  77.36,  NULL, NULL, 'jiedian.tel',  NULL, NULL, NULL),
(24,  NULL, 0,  NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'coolapp.app',  NULL, NULL, NULL),
(25,  3,  -1, NULL, 145,  1,  NULL, 368.55, 368.55, NULL, NULL, 'mov.cd', '2025-05-07 00:00:00',  '2026-05-07 00:00:00',  '2025-08-08 07:59:59'),
(26,  3,  0,  NULL, NULL, NULL, NULL, 136.51, 129.99, NULL, NULL, 'mov.cx', NULL, NULL, '2025-09-28 00:00:00'),
(27,  3,  0,  NULL, NULL, NULL, NULL, 82.31,  135.99, NULL, NULL, 'mov.lc', '2025-05-15 00:00:00',  '2026-05-15 00:00:00',  '2025-08-14 07:59:59'),
(28,  3,  0,  NULL, 141,  NULL, NULL, 26.67,  91.41,  NULL, NULL, 'jie.onl',  '2025-05-15 00:00:00',  '2026-05-15 00:00:00',  '2025-09-28 07:59:59');

DROP TABLE IF EXISTS `tip_git`;
CREATE TABLE `tip_git` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(250) DEFAULT NULL,
  `host` varchar(250) DEFAULT NULL,
  `port` varchar(250) DEFAULT NULL,
  `sublime_project` varchar(250) DEFAULT NULL,
  `branch` varchar(250) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `note` text,
  `flag` int(11) DEFAULT '0',
  `level` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `location` (`location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tip_git` (`id`, `location`, `host`, `port`, `sublime_project`, `branch`, `url`, `link`, `note`, `flag`, `level`, `created`, `updated`) VALUES
(1, 'J:\\Server\\VCS\\GitHub\\cnacker\\id\\master', NULL, NULL, 'id_master',  'master', 'git@github.com:cnacker/id.git',  NULL, NULL, 0,  0,  '2025-05-10 02:08:35',  NULL),
(2, 'J:\\git\\github.com\\wuding\\php-app\\future', NULL, '60116,60144',  'fu_app', 'future', 'git@github.com:wuding/php-app.git',  NULL, NULL, 0,  0,  '2025-05-10 23:15:09',  NULL),
(3, 'J:\\git\\github.com\\sync-backup\\bookmarks\\main',  NULL, NULL, 'm_bookmarks',  NULL, 'git@github.com:sync-backup/bookmarks.git', NULL, 'G:\\bookmarks.bat',  0,  0,  NULL, NULL),
(4, 'J:\\git\\github.com\\win-users\\AppData\\main',  NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0,  0,  NULL, NULL),
(5, 'J:\\git\\github.com\\app-module\\tutorail\\master',  NULL, '13202,13898',  'm_tupu', 'master', 'git@github.com:app-module/tutorial.git', 'https://github.com/app-module/tutorial', NULL, 0,  0,  '2025-06-15 09:28:27',  '2025-06-15 09:44:00'),
(6, 'J:\\git',  NULL, NULL, 'git_main', 'main', 'git@github.com:devops-env/git.git',  'https://github.com/devops-env/git',  NULL, 0,  0,  '2025-07-02 22:32:11',  NULL),
(7, 'J:\\Server\\Domain\\urlnk\\com\\@\\php-app\\app\\api2',  NULL, '1491', 'api',  'master', 'git@github.com:app-module/api.git',  'https://github.com/app-module/api',  NULL, 0,  0,  '2025-07-02 22:37:07',  NULL),
(8, 'J:\\Server\\VCS\\GitHub\\api-library\\movie\\develop', NULL, NULL, NULL, 'develop',  'git@github.com:api-library/movie.git', NULL, NULL, 0,  0,  '2025-07-02 22:39:55',  NULL),
(9, 'J:\\Server\\VCS\\GitHub\\app-module\\barcode\\main', NULL, '2313', 'barcode_main', 'main', 'git@github.com:app-module/barcode.git',  'https://github.com/app-module/barcode',  NULL, 0,  0,  '2025-07-02 22:42:32',  NULL),
(10,  'J:\\git\\github.com\\devops-env\\bat\\main', NULL, NULL, 'bat_main', 'main', 'git@github.com:devops-env/bat.git',  NULL, NULL, 0,  0,  '2025-07-02 22:47:47',  NULL),
(11,  'J:\\Server\\VCS\\GitHub\\app-module\\calendar\\main',  NULL, NULL, 'calendar_main',  'main', 'git@github.com:app-module/calendar.git', NULL, NULL, 0,  0,  '2025-07-02 22:50:04',  NULL),
(12,  'J:\\git\\github.com\\app-module\\chart\\main', NULL, NULL, 'chart_main', 'main', 'git@github.com:app-module/chart.git',  NULL, NULL, 0,  0,  '2025-07-02 22:51:03',  NULL),
(13,  'J:\\git\\github.com\\api-library\\domain\\main', NULL, '13415,13431',  'domain_main',  'main', 'git@github.com:api-library/domain.git',  'https://github.com/api-library/domain',  NULL, 0,  0,  '2025-07-02 22:52:38',  NULL),
(15,  'J:\\http\\php-app',  NULL, '40144',  'http_php-app', 'develop',  'git@github.com:wuding/php-app.git',  'https://github.com/wuding/php-app',  NULL, 0,  0,  '2025-07-02 22:54:44',  NULL),
(16,  'J:\\git\\github.com\\wuding\\php-ext\\future', NULL, '60508,60524',  'fu_ext', 'future', 'git@github.com:wuding/php-ext.git',  NULL, NULL, 0,  0,  '2025-07-02 22:56:10',  NULL),
(17,  'J:\\git\\github.com\\wuding\\magic-cube\\future',  NULL, '60618,60663',  'fu_frost', 'future', 'git@github.com:wuding/magic-cube.git', NULL, NULL, 0,  0,  '2025-07-02 22:57:39',  NULL),
(18,  'J:\\git\\github.com\\devops-env\\hosts\\master', NULL, NULL, 'host_master',  'master', 'git@github.com:devops-env/hosts.git',  NULL, NULL, 0,  0,  '2025-07-02 22:59:10',  NULL),
(19,  'J:\\git\\github.com\\apps-index\\coolapp.top\\main', NULL, '33834',  'm_coolapp.top',  'main', 'git@github.com:apps-index/coolapp.top.git',  'https://github.com/apps-index/coolapp.top',  NULL, 0,  0,  '2025-07-02 23:02:27',  NULL),
(20,  'J:\\git\\github.com\\api-library\\jd\\main', NULL, NULL, 'm_jd', 'main', 'git@github.com:api-library/jd.git',  NULL, NULL, 0,  0,  '2025-07-02 23:03:51',  NULL),
(21,  'J:\\git\\github.com\\apps-index\\movcd.com\\main', NULL, NULL, 'm_movcd',  NULL, 'git@github.com:apps-index/movcd.com.git',  NULL, NULL, 0,  0,  '2025-07-02 23:05:19',  NULL),
(22,  'J:\\git\\github.com\\apps-index\\movcd.cc\\main',  NULL, NULL, NULL, NULL, 'git@github.com:apps-index/movcd.cc.git', NULL, NULL, 0,  0,  '2025-07-02 23:06:26',  NULL),
(23,  'J:\\git\\github.com\\apps-index\\zzz.skin\\main',  NULL, NULL, NULL, NULL, 'git@github.com:apps-index/uuu.skin.git', NULL, NULL, 0,  0,  '2025-07-02 23:07:30',  NULL),
(24,  'J:\\git\\github.com\\wuding\\php-app\\future\\app\\search',  NULL, '13840',  'm_tpl',  'main', 'git@github.com:apps-index/.template.git',  'https://github.com/apps-index/.template',  NULL, 0,  0,  '2025-07-02 23:08:04',  NULL),
(27,  'J:\\Server\\Domain\\urlnk\\com\\@\\php-app\\vendor\\wuding\\magic-cube', NULL, NULL, NULL, NULL, 'git@github.com:wuding/magic-cube.git', NULL, NULL, 0,  0,  '2025-07-02 23:12:57',  NULL),
(28,  'J:\\Server\\VPS\\amsterdam\\home\\wwwroot\\movcd\\php-app',  NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0,  0,  '2025-07-02 23:14:02',  NULL),
(29,  'J:\\Server\\Domain\\urlnk\\com\\@\\php-app\\vendor\\wuding\\new-ui', NULL, NULL, NULL, NULL, 'git@github.com:wuding/new-ui.git', NULL, NULL, 0,  0,  '2025-07-02 23:14:53',  NULL),
(30,  'J:\\Server\\Domain\\urlnk\\com\\movcd\\php-app', NULL, NULL, NULL, NULL, 'git@github.com:wuding/php-app.git',  NULL, NULL, 0,  0,  '2025-07-02 23:15:31',  NULL),
(31,  'J:\\Server\\Domain\\urlnk\\com\\@\\php-app', NULL, NULL, NULL, NULL, 'git@github.com:wuding/php-app-v1.git', NULL, NULL, 0,  0,  NULL, NULL),
(32,  'J:\\Server\\Domain\\urlnk\\com\\@\\php-app\\vendor\\wuding\\php-ext',  NULL, '40508,40524',  'php-ext_develop',  'develop',  'git@github.com:wuding/php-ext.git',  NULL, NULL, 0,  0,  '2025-07-02 23:17:21',  NULL),
(33,  'J:\\Server\\VCS\\GitHub\\wuding\\php-ext\\master', NULL, NULL, NULL, NULL, 'git@github.com:wuding/php-ext.git',  NULL, NULL, 0,  0,  '2025-07-02 23:18:10',  NULL),
(34,  'J:\\Server\\VCS\\GitHub\\wuding\\php-func\\develop', NULL, NULL, NULL, NULL, 'git@github.com:wuding/php-func.git', NULL, NULL, 0,  0,  '2025-07-02 23:19:13',  NULL),
(35,  'J:\\Server\\Domain\\urlnk\\com\\@\\php-app\\vendor\\wuding\\php-pkg',  NULL, NULL, NULL, NULL, 'git@github.com:wuding/php-pkg.git',  NULL, NULL, 0,  0,  '2025-07-02 23:19:50',  NULL),
(36,  'J:\\Server\\VCS\\GitHub\\app-module\\play\\master',  NULL, NULL, NULL, NULL, 'git@github.com:app-module/play.git', NULL, NULL, 0,  0,  '2025-07-02 23:20:45',  NULL),
(37,  'J:\\Server\\Domain\\urlnk\\com\\@\\php-app\\app\\shopping',  NULL, NULL, NULL, NULL, 'git@github.com:app-module/shopping.git', NULL, NULL, 0,  0,  '2025-07-02 23:21:33',  NULL),
(38,  'J:\\git\\github.com\\apps-index\\softcool.app\\main',  NULL, NULL, NULL, NULL, 'git@github.com:apps-index/softcool.app.git', NULL, NULL, 0,  0,  '2025-07-02 23:22:19',  NULL),
(39,  'J:\\Server\\VCS\\GitHub\\api-library\\taobao\\main', NULL, NULL, NULL, NULL, 'git@github.com:api-library/taobao.git',  NULL, NULL, 0,  0,  '2025-07-02 23:23:19',  NULL),
(40,  'J:\\Server\\VCS\\GitHub\\wuding\\topdb\\develop',  NULL, NULL, NULL, NULL, 'git@github.com:wuding/topdb.git',  NULL, NULL, 0,  0,  '2025-07-02 23:24:00',  NULL),
(41,  'J:\\git\\github.com\\apps-index\\uuu.hair\\hair-main\\main', NULL, '55618,55819',  'u_hair', 'main', 'git@github.com:apps-index/uuu.hair.git', NULL, NULL, 0,  0,  '2025-07-02 23:24:56',  NULL),
(42,  'J:\\git\\github.com\\apps-index\\urlnk.com\\main\\urlnk.com',  NULL, NULL, NULL, NULL, 'git@github.com:apps-index/urlnk.com.git',  NULL, NULL, 0,  0,  '2025-07-02 23:25:49',  NULL),
(43,  'J:\\git\\github.com\\fork-copy\\html5-QR-BarCode\\master', NULL, NULL, NULL, NULL, 'git@github.com:fork-copy/html5-QR-BarCode.git',  NULL, NULL, 0,  0,  '2025-07-02 23:27:23',  NULL),
(44,  'J:\\git\\github.com\\apps-index\\zzz.kids\\main',  NULL, '22119,22211',  'z_kids', 'main', 'git@github.com:apps-index/zzz.kids.git', 'https://github.com/apps-index/zzz.kids', NULL, 0,  0,  '2025-07-02 23:28:14',  NULL),
(45,  'D:\\Search', NULL, NULL, NULL, NULL, NULL, NULL, '搜索条目收藏笔记', 0,  0,  NULL, NULL),
(46,  'J:\\git\\github.com\\fork-copy\\barcode\\master',  NULL, NULL, NULL, NULL, NULL, NULL, '条码导入', 0,  0,  NULL, NULL),
(47,  'K:\\application\\xml\\Task', NULL, NULL, NULL, NULL, NULL, NULL, 'xmlns',  0,  0,  NULL, NULL),
(48,  'J:\\git\\github.com\\apps-index\\zzz.spa\\main', NULL, '22596,22741',  'z_spa',  'main', 'git@github.com:apps-index/zzz.spa.git',  'https://github.com/apps-index/zzz.spa',  NULL, 0,  0,  '2025-07-04 18:18:40',  NULL),
(49,  'J:\\git\\github.com\\wuding\\php-func\\future',  NULL, '60621,60692',  NULL, NULL, NULL, NULL, NULL, 0,  0,  NULL, NULL);

DROP TABLE IF EXISTS `tip_project`;
CREATE TABLE `tip_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `note` text,
  `level` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `location` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tip_project` (`id`, `title`, `note`, `level`, `created`, `updated`, `location`) VALUES
(4, 'time', 'PHP Epoch Converter and Date/Time Routines\r\nhttps://www.epochconverter.com/programming/php\r\n\r\n谷歌浏览器WebKit/Chrome时间戳与普通Unix时间戳互转 - 带Python/PHP实现\r\nhttps://cloud.tencent.com/developer/article/2211531\r\n\r\n时间戳转换\r\nhttps://tool.lu/timestamp/\r\n\r\ngoogle chrome 获取书签的添加日期\r\nhttps://www.cnblogs.com/dontbealarmedimwithyou/p/18019659',  0,  '2025-05-12 15:33:48',  NULL, NULL),
(5, 'clipboard',  'https://pastebin.com/u/wuding',  0,  NULL, NULL, NULL),
(6, 'search', NULL, 1,  NULL, NULL, NULL),
(7, 'email',  NULL, 0,  NULL, NULL, NULL),
(8, 'downloads',  NULL, 0,  NULL, NULL, NULL),
(9, 'urls', NULL, 0,  NULL, NULL, NULL),
(10,  'movie',  NULL, 0,  NULL, NULL, NULL),
(11,  'bookmarks',  NULL, 0,  NULL, NULL, NULL);

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
  `mfg` datetime DEFAULT NULL,
  `ip` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ipname` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tip_vps` (`id`, `idc`, `cups`, `ram`, `disk`, `bandwidth`, `display_port`, `year`, `month`, `day`, `exp`, `mfg`, `ip`, `ipname`, `os`) VALUES
(1, 1215, 1,  2048, 20, 600,  100,  80, 6.67, 0.22, '2025-11-10 00:00:00',  '2024-11-10 05:58:58',  '167.88.177.149', 'Pghh.QgNi',  'CentOS-7.9.2111-x64'),
(2, 1215, 1,  6144, 40, 600,  100,  204.8,  17.06,  0.56, '2025-12-11 00:00:00',  NULL, '38.147.190.9', NULL, 'Windows-2008R2-Datacenter-cn'),
(3, 815,  2,  2048, 40, 800,  60, 378,  31.5, 1.04, '2025-03-17 00:00:00',  NULL, '103.51.145.68',  NULL, 'Windows 2008 R2 64位'),
(4, 815,  2,  2048, 40, 800,  60, 486,  40.5, 1.33, '2025-03-25 00:00:00',  NULL, '103.51.145.55',  NULL, 'Windows 2008 R2 64位'),
(5, 195,  1,  2048, 30, NULL, 50, 640.2,  53.35,  1.76, '2025-11-22 00:00:00',  NULL, '78.111.86.41', NULL, 'CentOS 7.9 x64'),
(6, 195,  1,  1024, 25, NULL, NULL, 403.8,  33.65,  1.11, NULL, NULL, NULL, NULL, NULL),
(7, 195,  1,  2048, 25, NULL, NULL, 595.92, 49.66,  1.63, NULL, NULL, NULL, NULL, NULL),
(8, 1215, 4,  8192, 40, 800,  150,  198.4,  16.57,  0.55, '2026-05-07 00:00:00',  NULL, '38.55.125.98', NULL, 'Windows-2008R2-Datacenter-cn');

-- 2025-07-04 12:37:19.4 UTC
