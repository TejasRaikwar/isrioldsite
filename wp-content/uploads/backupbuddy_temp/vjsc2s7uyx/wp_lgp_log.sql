CREATE TABLE `wp_lgp_log` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `time` int(11) NOT NULL DEFAULT '0',  `log` text COLLATE utf8mb4_unicode_520_ci NOT NULL,  `show` tinyint(1) NOT NULL DEFAULT '0',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_lgp_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_lgp_log` ENABLE KEYS */;
